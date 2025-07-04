<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Fixture\Faker;

use Faker\Provider\Base;

final class MarkdownProvider extends Base
{
    public function markdownContent(int $paragraphs = 10): string
    {
        $currentTitleLevel = 2;

        $result = [
            $this->markdownTitle(
                words: $this->generator->numberBetween(1, 10),
                level: $currentTitleLevel++,
            ),
        ];

        for ($i = 0; $i < $paragraphs; ++$i) {
            $result[] = match ($this->generator->numberBetween(1, 10)) {
                1, 2 => $this->markdownCode(
                    lines: $this->generator->numberBetween(1, 30),
                    lang: $this->generator->randomElement(['', 'php']),
                ),
                3 => $this->markdownList(
                    elements: $this->generator->numberBetween(3, 10),
                ),
                4 => match ($this->generator->numberBetween(1, 5)) {
                    1 => $this->markdownTitle(
                        words: $this->generator->numberBetween(1, 10),
                        level: $currentTitleLevel,
                    ),
                    2 => $this->markdownTitle(
                        words: $this->generator->numberBetween(1, 10),
                        level: $currentTitleLevel++,
                    ),
                    default => (function () use (&$currentTitleLevel): string {
                        $currentTitleLevel = $this->generator->numberBetween(2, $currentTitleLevel);

                        return $this->markdownTitle(
                            words: $this->generator->numberBetween(1, 10),
                            level: $currentTitleLevel,
                        );
                    })(),
                },
                default => $this->generator->text(
                    $this->generator->numberBetween(200, 500),
                ),
            };
        }

        return \implode("\n\n", $result);
    }

    /**
     * @param int<1, max> $words
     * @param int<1, max> $level
     */
    public function markdownTitle(int $words = 6, int $level = 1): string
    {
        return \str_repeat('#', $level) . ' '
            . \rtrim($this->generator->sentence($words), '.');
    }

    public function markdownCode(int $lines = 10, string $lang = ''): string
    {
        $sourceCode = \file(__FILE__, \FILE_SKIP_EMPTY_LINES | \FILE_IGNORE_NEW_LINES);
        $targetCode = [];

        for ($i = 0; $i < $lines; ++$i) {
            $targetCode[] = \rtrim($this->generator->randomElement($sourceCode), '.');
        }

        $targetCodeAsString = \implode("\n", $targetCode);

        return <<<MARKDOWN
            ```{$lang}
            $targetCodeAsString
            ```
            MARKDOWN;
    }

    public function markdownList(int $elements = 6): string
    {
        $result = [];

        for ($i = 0; $i < $elements; ++$i) {
            $result[] = '- ' . \rtrim($this->generator->sentence(1, 15), '.');
        }

        return \implode("\n", $result);
    }
}
