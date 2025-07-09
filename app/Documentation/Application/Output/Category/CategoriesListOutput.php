<?php

declare(strict_types=1);

namespace App\Documentation\Application\Output\Category;

use App\Documentation\Domain\Category\Category;
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
        $mapped = [];

        foreach ($categories as $category) {
            $mapped[] = CategoryOutput::fromCategory($category);
        }

        return new self($mapped);
    }
}
