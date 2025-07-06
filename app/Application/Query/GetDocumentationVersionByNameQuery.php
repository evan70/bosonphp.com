<?php

declare(strict_types=1);

namespace App\Application\Query;

final readonly class GetDocumentationVersionByNameQuery
{
    public function __construct(
        public ?string $version = null,
    ) {}
}
