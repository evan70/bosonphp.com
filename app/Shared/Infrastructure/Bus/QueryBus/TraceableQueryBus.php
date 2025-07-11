<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus\QueryBus;

use App\Shared\Domain\Bus\QueryBusInterface;
use Symfony\Component\Stopwatch\Stopwatch;

final readonly class TraceableQueryBus implements QueryBusInterface
{
    public function __construct(
        private QueryBusInterface $delegate,
        private Stopwatch $stopwatch,
    ) {}

    public function get(object $query): mixed
    {
        $span = $this->stopwatch->start($query::class, 'query.bus');

        $result = $this->delegate->get($query);

        $span->stop();

        return $result;
    }
}
