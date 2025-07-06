<?php

declare(strict_types=1);

namespace App\Domain\Blog\Repository;

use App\Domain\Blog\Article;
use App\Domain\Blog\Category\ArticleCategory;
use Doctrine\ORM\Tools\Pagination\Paginator;

interface ArticlePaginateProviderInterface
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
     * @return Paginator<Article>
     */
    public function getAllAsPaginator(
        int $page = self::DEFAULT_PAGE,
        int $itemsPerPage = self::DEFAULT_ITEMS_PER_PAGE,
        ?ArticleCategory $category = null,
    ): Paginator;
}
