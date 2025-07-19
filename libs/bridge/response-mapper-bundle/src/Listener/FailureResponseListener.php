<?php

declare(strict_types=1);

namespace Local\Bridge\ResponseMapper\Listener;

use Local\Bridge\ResponseMapper\ResponseMapperInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;

final readonly class FailureResponseListener extends ResponseListener
{
    public function __invoke(ExceptionEvent $event): void
    {
        $version = $this->fetchApiVersion($event);

        if ($version === null) {
            return;
        }

        $payload = $event->getThrowable();

        $event->setResponse($this->encode(
            request: $event->getRequest(),
            data: $this->process($version, $payload),
        ));
    }

    #[\Override]
    protected function extend(Response $response, mixed $data): void
    {
        if (!$data instanceof HttpException) {
            return;
        }

        $response->setStatusCode($data->getStatusCode());
        $response->headers->add($data->getHeaders());
    }

    private function process(string $version, \Throwable $payload): mixed
    {
        if (!$this->mappers->has($version)) {
            return $payload;
        }

        /** @var ResponseMapperInterface $mapper */
        $mapper = $this->mappers->get($version);

        return $mapper->onFailure($payload);
    }
}
