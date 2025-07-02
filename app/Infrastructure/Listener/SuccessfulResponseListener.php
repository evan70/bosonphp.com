<?php

declare(strict_types=1);

namespace App\Infrastructure\Listener;

use App\Presentation\Api\Response\DTO\ApiResponseDTO;
use App\Presentation\Api\Response\DTO\ApiSuccessResponseDTO;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\ViewEvent;

#[AsEventListener(priority: 64)]
final class SuccessfulResponseListener
{
    public function __invoke(ViewEvent $e): void
    {
        $request = $e->getRequest();
        $payload = $e->getControllerResult();

        $e->setControllerResult(match ($request->attributes->get('api')) {
            'v1' => $this->processApiV1($payload),
            default => $payload,
        });
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
