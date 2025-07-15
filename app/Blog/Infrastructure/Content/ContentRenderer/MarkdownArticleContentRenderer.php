<?php

declare(strict_types=1);

namespace App\Blog\Infrastructure\Content\ContentRenderer;

use App\Blog\Domain\Content\ArticleContent;
use App\Blog\Domain\Content\ArticleContentRendererInterface;
use League\CommonMark\ConverterInterface;

/**
 * @api
 *
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal App\Blog\Infrastructure\ContentRenderer
 */
final readonly class MarkdownArticleContentRenderer implements ArticleContentRendererInterface
{
    public function __construct(
        private ConverterInterface $converter,
    ) {}

    public function renderContent(object $target): string
    {
        assert($target instanceof ArticleContent);

        return $this->converter->convert($target->value)
                ->getContent();
    }
}
