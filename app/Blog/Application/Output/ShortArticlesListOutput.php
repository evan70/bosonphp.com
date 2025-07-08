<?php

namespace App\Blog\Application\Output;

use App\Blog\Domain\Article;
use App\Shared\Application\Output\CountableCollectionOutput;

/**
 * @template-extends CountableCollectionOutput<ShortArticleOutput>
 */
final readonly class ShortArticlesListOutput extends
    CountableCollectionOutput
{
    /**
     * @param int<0, max> $itemsPerPage
     * @param \Countable&\Traversable<mixed, Article> $paginator
     */
    public static function fromArticlesPaginator(int $itemsPerPage, \Traversable&\Countable $paginator): self
    {
        $items = [];

        foreach ($paginator as $article) {
            $items[] = ShortArticleOutput::fromArticle($article);
        }

        return new self(
            items: $items,
            itemsPerPage: $itemsPerPage,
            count: $paginator->count(),
        );
    }
}
