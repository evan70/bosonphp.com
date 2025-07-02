<?php

declare(strict_types=1);

namespace Local\Bridge\TypeLang\Listener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use TypeLang\Mapper\NormalizerInterface;

final readonly class ControllerResultNormalizerListener
{
    public function __construct(
        private NormalizerInterface $normalizer,
    ) {}

    public function __invoke(ViewEvent $event): void
    {
        /** @psalm-var mixed $result */
        $result = $event->getControllerResult();

        if ($result instanceof Response) {
            return;
        }

        $normalized = $this->normalizer->normalize($result);

        $event->setControllerResult($normalized);
    }
}
