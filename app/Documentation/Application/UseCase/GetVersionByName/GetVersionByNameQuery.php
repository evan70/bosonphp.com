<?php

declare(strict_types=1);

namespace App\Documentation\Application\UseCase\GetVersionByName;

final readonly class GetVersionByNameQuery
{
    public function __construct(
        public ?string $version = null,
    ) {}
}
