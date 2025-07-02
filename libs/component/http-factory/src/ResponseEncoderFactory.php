<?php

declare(strict_types=1);

namespace Local\Component\HttpFactory;

use Symfony\Component\HttpFoundation\Request;

final readonly class ResponseEncoderFactory implements ResponseEncoderFactoryInterface
{
    /**
     * @var list<ResponseMatcherInterface>
     */
    private array $encoders;

    /**
     * @param iterable<mixed, ResponseMatcherInterface> $encoders
     */
    public function __construct(iterable $encoders = [])
    {
        $this->encoders = \iterator_to_array($encoders, false);
    }

    public function createEncoder(Request $request): ?ResponseEncoderInterface
    {
        foreach ($this->encoders as $factory) {
            if ($factory->isAcceptable($request)) {
                return $factory;
            }
        }

        return null;
    }
}
