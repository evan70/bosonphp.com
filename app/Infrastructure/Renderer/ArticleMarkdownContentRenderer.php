<?php

declare(strict_types=1);

namespace App\Infrastructure\Renderer;

use App\Domain\Article\Content\RendererInterface;
use League\CommonMark\ConverterInterface;

final readonly class ArticleMarkdownContentRenderer implements RendererInterface
{
    public function __construct(
        private ConverterInterface $converter,
    ) {}

    public function render(string $content): string
    {
        return $this->converter->convert($content)
            ->getContent();
    }
}
