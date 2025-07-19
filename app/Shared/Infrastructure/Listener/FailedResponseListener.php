<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Listener;

use App\Shared\Presentation\Api\Response\DTO\ApiFailureResponseDTO;
use App\Shared\Presentation\Api\Response\DTO\ApiResponseDTO;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;

#[AsEventListener(priority: 64)]
final readonly class FailedResponseListener extends ResponseListener
{
    public function __invoke(ExceptionEvent $event): void
    {
        $version = $this->fetchApiVersion($event);

        if ($version === null) {
            return;
        }

        $payload = $event->getThrowable();

        $response = $this->encode(
            request: $event->getRequest(),
            data: $this->process(
                version: $version,
                payload: $payload,
            ),
        );

        if ($payload instanceof HttpException) {
            $response->setStatusCode($payload->getStatusCode());
            $response->headers->add($payload->getHeaders());
        }

        $event->setResponse($response);
    }

    /**
     * @param non-empty-string $version
     */
    private function process(string $version, \Throwable $payload): mixed
    {
        return match ($version) {
            'v1' => $this->processApiV1($payload),
            default => $payload,
        };
    }

    private function processApiV1(\Throwable $payload): ApiResponseDTO
    {
        $data = null;

        if ($this->debug) {
            $data = (string) $payload;
        }

        return new ApiFailureResponseDTO(
            error: match (true) {
                $payload instanceof HttpException => $payload->getMessage(),
                default => 'Internal Server Error',
            },
            data: $data,
        );
    }
}
