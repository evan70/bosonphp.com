<?php

declare(strict_types=1);

namespace App\Documentation\Application\UseCase\GetPageByName;

final readonly class GetPageByNameQuery
{
    public function __construct(
        public string $name,
        public ?string $version = null,
    ) {}
}
