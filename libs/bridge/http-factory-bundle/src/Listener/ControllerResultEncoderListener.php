<?php

declare(strict_types=1);

namespace Local\Bridge\HttpFactory\Listener;

use Local\Component\HttpFactory\ResponseEncoderInterface;
use Local\Component\HttpFactory\ResponseEncoderFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ViewEvent;

final readonly class ControllerResultEncoderListener
{
    public function __construct(
        private ResponseEncoderFactoryInterface $factory,
        private ResponseEncoderInterface $default,
    ) {}

    public function __invoke(ViewEvent $event): void
    {
        /** @psalm-var mixed $result */
        $result = $event->getControllerResult();

        if ($result instanceof Response) {
            return;
        }

        /** @var object|array<array-key, mixed> $result */
        $this->modify($event->getRequest(), $result, $event);
    }

    private function modify(Request $request, mixed $result, ViewEvent $event): void
    {
        $factory = $this->factory->createEncoder($request) ?? $this->default;

        $event->setResponse($factory->encode($result));
        $event->stopPropagation();
    }
}
