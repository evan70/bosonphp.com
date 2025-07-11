<?php

declare(strict_types=1);

namespace App\Documentation\Application\UseCase\UpdateCategories\UpdateCategoriesCommand;

final readonly class CategoryIndex
{
    public function __construct(
        /**
         * @var non-empty-lowercase-string
         */
        public string $hash,
        /**
         * @var non-empty-string
         */
        public string $name,
        /**
         * @var non-empty-string|null
         */
        public ?string $description = null,
        /**
         * @var non-empty-string|null
         */
        public ?string $icon = null,
    ) {}
}
