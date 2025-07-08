<?php

declare(strict_types=1);

namespace App\Documentation\Application\Query;

final readonly class GetDocumentationPageByNameQuery
{
    public function __construct(
        public string $name,
        public ?string $version = null,
    ) {}
}
