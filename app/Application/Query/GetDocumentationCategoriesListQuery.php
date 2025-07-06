<?php

declare(strict_types=1);

namespace App\Application\Query;

final readonly class GetDocumentationCategoriesListQuery
{
    public function __construct(
        /**
         * @var non-empty-string|null
         */
        public ?string $version = null,
    ) {}
}
