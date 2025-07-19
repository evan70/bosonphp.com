<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Response;

use App\Shared\Presentation\Api\Response\DTO\ApiFailureResponseDTO;
use App\Shared\Presentation\Api\Response\DTO\ApiResponseDTO;
use App\Shared\Presentation\Api\Response\DTO\ApiSuccessResponseDTO;
use Local\Bridge\ResponseMapper\ResponseMapperInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;

final readonly class ApiV1Mapper implements ResponseMapperInterface
{
    public function __construct(
        private bool $debug,
    ) {}

    public function onSuccess(mixed $payload): ApiResponseDTO
    {
        if ($payload instanceof ApiResponseDTO) {
            return $payload;
        }

        return new ApiSuccessResponseDTO(
            data: $payload,
        );
    }

    public function onFailure(\Throwable $error): ApiResponseDTO
    {
        return new ApiFailureResponseDTO(
            error: match (true) {
                $error instanceof HttpException => $error->getMessage(),
                default => 'Internal Server Error',
            },
            data: $this->getFailureData($error),
        );
    }

    /**
     * @param \Throwable $error
     * @return array<array-key, mixed>|null
     */
    private function getFailureData(\Throwable $error): ?array
    {
        if ($this->debug !== true) {
            return null;
        }

        return [
            'error' => $error::class . ': ' . $error->getMessage(),
            'in' => \sprintf('%s:%d', $error->getFile(), $error->getLine()),
            'trace' => \array_map(self::mapTraceItem(...), $error->getTrace()),
        ];
    }

    /**
     * @param array{
     *     file?: string,
     *     line?: int,
     *     ...
     * } $trace
     *
     * @return non-empty-string
     */
    private static function mapTraceItem(array $trace): string
    {
        $trace['file'] ??= '{main}';
        $trace['line'] ??= 0;

        return \sprintf('%s:%d', $trace['file'], $trace['line']);
    }
}
