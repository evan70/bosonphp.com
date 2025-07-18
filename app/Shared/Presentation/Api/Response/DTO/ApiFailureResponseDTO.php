<?php

declare(strict_types=1);

namespace App\Shared\Presentation\Api\Response\DTO;

/**
 * @template TData of mixed = mixed
 * @template-extends ApiResponseDTO<TData>
 */
final readonly class ApiFailureResponseDTO extends ApiResponseDTO
{
    public function __construct(
        public string $error,
        mixed $data = null,
    ) {
        parent::__construct($data);
    }
}
