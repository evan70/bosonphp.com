<?php

namespace App\Blog\Application\Output;

use App\Blog\Domain\Category\Category;
use App\Shared\Application\Output\CollectionOutput;

/**
 * @template-extends CollectionOutput<CategoryOutput>
 */
final readonly class CategoriesListOutput extends CollectionOutput
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
