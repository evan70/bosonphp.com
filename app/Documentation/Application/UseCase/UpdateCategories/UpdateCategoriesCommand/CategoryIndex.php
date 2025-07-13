<?php

declare(strict_types=1);

namespace App\Documentation\Application\UseCase\UpdateCategories\UpdateCategoriesCommand;

use Symfony\Component\Validator\Constraints\NotBlank;

final readonly class CategoryIndex
{
    public function __construct(
        /**
         * @var non-empty-lowercase-string
         */
        #[NotBlank]
        public string $hash,
        /**
         * @var non-empty-string
         */
        #[NotBlank]
        public string $name,
        /**
         * @var non-empty-string|null
         */
        #[NotBlank]
        public ?string $description = null,
        /**
         * @var non-empty-string|null
         */
        #[NotBlank]
        public ?string $icon = null,
    ) {}
}
