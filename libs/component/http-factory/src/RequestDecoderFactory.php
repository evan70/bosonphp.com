<?php

declare(strict_types=1);

namespace Local\Component\HttpFactory;

use Symfony\Component\HttpFoundation\Request;

final readonly class RequestDecoderFactory implements RequestDecoderFactoryInterface
{
    /**
     * @var list<RequestMatcherInterface>
     */
    private array $decoders;

    /**
     * @param iterable<mixed, RequestMatcherInterface> $decoders
     */
    public function __construct(iterable $decoders = [])
    {
        $this->decoders = \iterator_to_array($decoders, false);
    }

    public function createDecoder(Request $request): ?RequestDecoderInterface
    {
        foreach ($this->decoders as $decoder) {
            if ($decoder->isProvides($request)) {
                return $decoder;
            }
        }

        return null;
    }
}
