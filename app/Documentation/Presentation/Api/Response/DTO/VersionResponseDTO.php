<?php

declare(strict_types=1);

namespace App\Documentation\Presentation\Api\Response\DTO;

final readonly class VersionResponseDTO
{
    public function __construct(
        public string $version,
    ) {}
}
