<?php

declare(strict_types=1);

namespace App\Blog\Domain\Repository;

use App\Blog\Domain\Article;
use App\Blog\Domain\Category\Category;

interface ArticlesListPaginateProviderInterface
{
    /**
     * @var int<1, max>
     */
    public const int DEFAULT_PAGE = 1;

    /**
     * @var int<1, max>
     */
    public const int DEFAULT_ITEMS_PER_PAGE = 10;

    /**
     * @param int<1, max> $page
     * @param int<1, max> $itemsPerPage
     *
     * @return \Traversable<array-key, Article>&\Countable
     */
    public function getAllAsPaginator(
        int $page = self::DEFAULT_PAGE,
        int $itemsPerPage = self::DEFAULT_ITEMS_PER_PAGE,
        ?Category $category = null,
    ): \Traversable&\Countable;
}
