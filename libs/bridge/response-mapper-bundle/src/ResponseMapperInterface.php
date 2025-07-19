<?php

declare(strict_types=1);

namespace Local\Bridge\ResponseMapper;

interface ResponseMapperInterface
{
    public function onSuccess(mixed $payload): mixed;

    public function onFailure(\Throwable $error): mixed;
}
