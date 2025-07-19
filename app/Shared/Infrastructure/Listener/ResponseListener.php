<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Listener;

use Local\Component\HttpFactory\ResponseEncoderFactoryInterface;
use Local\Component\HttpFactory\ResponseEncoderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\KernelEvent;

abstract readonly class ResponseListener
{
    public function __construct(
        protected bool $debug,
        private ResponseEncoderFactoryInterface $factory,
        private ResponseEncoderInterface $default,
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

        return $encoder->encode($data);
    }
}
