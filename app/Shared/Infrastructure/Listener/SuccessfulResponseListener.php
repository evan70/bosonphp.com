<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Listener;

use App\Shared\Presentation\Api\Response\DTO\ApiResponseDTO;
use App\Shared\Presentation\Api\Response\DTO\ApiSuccessResponseDTO;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\ViewEvent;

#[AsEventListener(priority: 64)]
final readonly class SuccessfulResponseListener extends ResponseListener
{
    public function __invoke(ViewEvent $event): void
    {
        $version = $this->fetchApiVersion($event);

        if ($version === null) {
            return;
        }

        $payload = $event->getControllerResult();

        $response = $this->encode(
            request: $event->getRequest(),
            data: $this->process(
                version: $version,
                payload: $payload,
            ),
        );

        // TODO extend response

        $event->setResponse($response);
    }

    /**
     * @param non-empty-string $version
     */
    private function process(string $version, mixed $payload): mixed
    {
        return match ($version) {
            'v1' => $this->processApiV1($payload),
            default => $payload,
        };
    }

    private function processApiV1(mixed $payload): ApiResponseDTO
    {
        if ($payload instanceof ApiResponseDTO) {
            return $payload;
        }

        return new ApiSuccessResponseDTO(
            data: $payload,
        );
    }
}
