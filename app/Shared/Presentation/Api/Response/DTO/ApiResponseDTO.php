<?php

declare(strict_types=1);

namespace App\Shared\Presentation\Api\Response\DTO;

/**
 * @template TData of mixed = mixed
 */
abstract readonly class ApiResponseDTO
{
    /**
     * @param TData|null $data
     */
    public function __construct(
        public mixed $data = null,
        public string $version = '1.0',
    ) {}
}
