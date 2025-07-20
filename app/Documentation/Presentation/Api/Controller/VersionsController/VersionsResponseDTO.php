<?php

declare(strict_types=1);

namespace App\Documentation\Presentation\Api\Controller\VersionsController;

use App\Documentation\Presentation\Api\Response\DTO\VersionResponseDTO;

final readonly class VersionsResponseDTO
{
    public function __construct(
        public VersionResponseDTO $current,
    ) {}
}
