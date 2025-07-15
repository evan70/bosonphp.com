<?php

declare(strict_types=1);

namespace App\Documentation\Infrastructure\PageTitleExtractor;

use App\Documentation\Domain\Page;
use App\Documentation\Domain\PageDocument;
use App\Documentation\Domain\PageTitleExtractorInterface;

final readonly class MarkdownTitleExtractor implements PageTitleExtractorInterface
{
    public function __construct(
        private PageTitleExtractorInterface $delegate,
    ) {}

    public function extractTitle(Page $page): string
    {
        if ($page instanceof PageDocument) {
            return $this->findFromContent($page->content->value)
                ?? $this->delegate->extractTitle($page);
        }

        return $this->delegate->extractTitle($page);
    }

    /**
     * Extract title from first markdown-like title "# ..." sequence
     *
     * @return non-empty-string|null
     */
    private function findFromContent(string $content): ?string
    {
        \preg_match('/^#+\h+(.+?)$/ium', $content, $matches);

        return $matches[1] ?? null;
    }
}
