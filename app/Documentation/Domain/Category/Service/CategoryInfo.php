<?php

declare(strict_types=1);

namespace App\Documentation\Domain\Category\Service;

/**
 * Value object representing external category information for synchronization.
 * Used as input for change set computation.
 */
final readonly class CategoryInfo
{
    public function __construct(
        /**
         * Hash of the category (e.g., content hash)
         * @var non-empty-lowercase-string
         */
        public string $hash,
        /**
         * Name of the category (e.g., 'API')
         * @var non-empty-string
         */
        public string $name,
        /**
         * Description of the category (optional)
         * @var non-empty-string|null
         */
        public ?string $description = null,
        /**
         * Icon for the category (optional)
         * @var non-empty-string|null
         */
        public ?string $icon = null,
    ) {}
}
