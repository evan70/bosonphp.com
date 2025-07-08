<?php

declare(strict_types=1);

namespace App\Blog\Domain\Category\Repository;

use App\Blog\Domain\Category\Category;

interface CategoryByUriProviderInterface
{
    /**
     * @param non-empty-string $uri
     */
    public function findByUri(string $uri): ?Category;
}
