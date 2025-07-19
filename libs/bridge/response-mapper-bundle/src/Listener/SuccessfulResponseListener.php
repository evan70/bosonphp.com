<?php

declare(strict_types=1);

namespace Local\Bridge\ResponseMapper\Listener;

use Local\Bridge\ResponseMapper\ResponseMapperInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;

final readonly class SuccessfulResponseListener extends ResponseListener
{
    public function __invoke(ViewEvent $event): void
    {
        $version = $this->fetchApiVersion($event);

        if ($version === null) {
            return;
        }

        $payload = $event->getControllerResult();

        $event->setResponse($this->encode(
            request: $event->getRequest(),
            data: $this->process($version, $payload),
        ));
    }

    private function process(string $version, mixed $payload): mixed
    {
        if (!$this->mappers->has($version)) {
            return $payload;
        }

        /** @var ResponseMapperInterface $mapper */
        $mapper = $this->mappers->get($version);

        return $mapper->onSuccess($payload);
    }
}
