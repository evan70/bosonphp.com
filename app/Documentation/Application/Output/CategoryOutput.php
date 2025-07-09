<?php

declare(strict_types=1);

namespace App\Documentation\Application\Output;

use App\Documentation\Domain\Category\Category;

final readonly class CategoryOutput
{
    public function __construct(
        /**
         * @var non-empty-string
         */
        public string $title,
        /**
         * @var non-empty-string|null
         */
        public ?string $description,
        /**
         * @var non-empty-string|null
         */
        public ?string $icon,
    ) {}

    public static function fromCategory(Category $category): self
    {
        $description = $category->description;

        if ($description === '') {
            $description = null;
        }

        return new self(
            title: $category->title,
            description: $description,
            icon: $category->icon,
        );
    }
}
