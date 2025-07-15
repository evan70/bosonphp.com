<?php

declare(strict_types=1);

namespace App\Blog\Infrastructure\Renderer;

use App\Blog\Domain\ArticleContent;
use App\Blog\Domain\ArticleContentRendererInterface;
use League\CommonMark\ConverterInterface;

/**
 * @api
 *
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal App\Blog\Infrastructure\Renderer
 */
final readonly class ArticleContentRenderer implements ArticleContentRendererInterface
{
    public function __construct(
        private ConverterInterface $converter,
    ) {}

    public function renderContent(object $entity): RenderingArticleContentResult
    {
        assert($entity instanceof ArticleContent);

        return new RenderingArticleContentResult(
            content: $this->converter->convert($entity->value)
                ->getContent(),
        );
    }
}
