<?php

declare(strict_types=1);

namespace Local\Bridge\ResponseMapper\Listener;

use Local\Component\HttpFactory\ResponseEncoderFactoryInterface;
use Local\Component\HttpFactory\ResponseEncoderInterface;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\KernelEvent;

abstract readonly class ResponseListener
{
    public function __construct(
        private ResponseEncoderFactoryInterface $factory,
        private ResponseEncoderInterface $default,
        protected ContainerInterface $mappers,
    ) {}

    /**
     * @return non-empty-string|null
     */
    protected function fetchApiVersion(KernelEvent $event): ?string
    {
        if (!$event->isMainRequest()) {
            return null;
        }

        $request = $event->getRequest();
        $result = $request->attributes->get('api');

        if (\is_string($result) && $result !== '') {
            return $result;
        }

        return null;
    }

    protected function encode(Request $request, mixed $data): Response
    {
        $encoder = $this->factory->createEncoder($request)
            ?? $this->default;

        $response = $encoder->encode($data);

        $this->extend($response, $data);

        return $response;
    }

    protected function extend(Response $response, mixed $data): void
    {
        // TODO
    }
}
