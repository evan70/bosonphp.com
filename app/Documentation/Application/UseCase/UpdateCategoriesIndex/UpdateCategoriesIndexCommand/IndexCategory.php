<?php

declare(strict_types=1);

namespace App\Documentation\Application\UseCase\UpdateCategoriesIndex\UpdateCategoriesIndexCommand;

final readonly class IndexCategory
{
    public function __construct(
        /**
         * @var non-empty-string
         */
        public string $category,
        /**
         * @var non-empty-string
         */
        public string $hash,
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
