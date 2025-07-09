<?php

declare(strict_types=1);

namespace App\Blog\Application\Output\Category;

use App\Blog\Domain\Category\Category;
use App\Shared\Application\Output\CollectionOutput;

/**
 * @template-extends CollectionOutput<CategoryOutput>
 */
final class CategoriesListOutput extends CollectionOutput
{
    /**
     * @param iterable<mixed, Category> $categories
     */
    public static function fromCategories(iterable $categories): self
    {
        $result = [];

        foreach ($categories as $category) {
            $result[] = CategoryOutput::fromCategory($category);
        }

        return new self($result);
    }
}
