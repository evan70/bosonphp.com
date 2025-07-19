<?php

declare(strict_types=1);

namespace Local\Component\HttpFactory;

interface RequestDecoderInterface
{
    public function decode(string $payload): mixed;
}
