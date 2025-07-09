<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus\QueryBus;

use App\Shared\Domain\Bus\QueryBusInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\TerminableInterface;

final class InMemoryQueryBus implements QueryBusInterface, TerminableInterface
{
    /**
     * @var array<non-empty-string, mixed>
     */
    private array $memory = [];

    public function __construct(
        private readonly QueryBusInterface $delegate,
    ) {}

    public function get(object $query): mixed
    {
        return $this->memory[$this->keyOfQuery($query)]
            ??= $this->delegate->get($query);
    }

    /**
     * @return non-empty-string
     */
    private function keyOfQuery(object $query): string
    {
        return \hash('xxh3', \serialize($query));
    }

    public function terminate(Request $request, Response $response): void
    {
        $this->memory = [];
    }
}
