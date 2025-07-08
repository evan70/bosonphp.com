<?php

declare(strict_types=1);

namespace App\Blog\Domain\Category\Repository;

use App\Blog\Domain\Category\Category;

interface ArticleCategoryListProviderInterface
{
    /**
     * @return iterable<array-key, Category>
     */
    public function getAll(): iterable;
}
