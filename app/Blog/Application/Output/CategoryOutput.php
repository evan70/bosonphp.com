<?php

namespace App\Blog\Application\Output;

use App\Blog\Domain\Category\Category;

/**
 * Represents a blog category output.
 */
final readonly class CategoryOutput
{
    public function __construct(
        /**
         * The title of the category.
         *
         * @var non-empty-string
         */
        public string $title,
        /**
         * The unique URI slug of the category.
         *
         * @var non-empty-string
         */
        public string $uri,
    ) {}

    public static function fromCategory(Category $category): self
    {
        return new self(
            title: $category->title,
            uri: $category->uri,
        );
    }

    public static function fromOptionalCategory(?Category $category): ?self
    {
        if ($category === null) {
            return null;
        }

        return self::fromCategory($category);
    }
}
