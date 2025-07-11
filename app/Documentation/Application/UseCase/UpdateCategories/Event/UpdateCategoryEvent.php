<?php

declare(strict_types=1);

namespace App\Documentation\Application\UseCase\UpdateCategories\Event;

abstract readonly class UpdateCategoryEvent
{
    public function __construct(
        /**
         * @var non-empty-string
         */
        public string $version,
        /**
         * @var non-empty-string
         */
        public string $name,
    ) {}
}
