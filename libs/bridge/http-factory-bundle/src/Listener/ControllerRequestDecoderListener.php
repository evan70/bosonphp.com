<?php

declare(strict_types=1);

namespace Local\Bridge\HttpFactory\Listener;

use Local\Component\HttpFactory\RequestDecoderFactoryInterface;
use Local\Component\HttpFactory\RequestDecoderInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;

final readonly class ControllerRequestDecoderListener
{
    /**
     * @var non-empty-list<non-empty-string>
     */
    private const array METHODS_WITHOUT_BODY = [
        'GET',
        'HEAD',
        'OPTIONS',
    ];

    public function __construct(
        private RequestDecoderFactoryInterface $factory,
        private RequestDecoderInterface $default,
    ) {}

    public function __invoke(RequestEvent $event): void
    {
        $request = $event->getRequest();

        if (\in_array($request->getMethod(), self::METHODS_WITHOUT_BODY, true)) {
            return;
        }

        $decoder = $this->factory->createDecoder($request)
            ?? $this->default;

        $request->attributes->set('_body', $decoder->decode($request->getContent()));
    }
}
