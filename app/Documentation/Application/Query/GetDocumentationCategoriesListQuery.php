<?php

declare(strict_types=1);

namespace App\Documentation\Application\Query;

final readonly class GetDocumentationCategoriesListQuery
{
    public function __construct(
        public ?string $version = null,
    ) {}
}
