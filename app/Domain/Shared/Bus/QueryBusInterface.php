<?php

declare(strict_types=1);

namespace App\Domain\Shared\Bus;

interface QueryBusInterface
{
    public function get(object $query): mixed;
}
