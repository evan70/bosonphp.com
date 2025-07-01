<?php

declare(strict_types=1);

namespace App\Domain\Article\Repository;

use App\Domain\Article\Article;

interface ArticlePaginateProviderInterface
{
    /**
     * @param int<1, max> $page
     *
     * @return iterable<array-key, Article>
     */
    public function getAllAsPaginator(int $page = 1): iterable;
}
