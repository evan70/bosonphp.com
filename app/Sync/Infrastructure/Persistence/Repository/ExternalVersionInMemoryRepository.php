<?php

declare(strict_types=1);

namespace App\Sync\Infrastructure\Persistence\Repository;

use App\Sync\Domain\Version\ExternalVersion;
use App\Sync\Domain\Version\ExternalVersionRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\TerminableInterface;

final class ExternalVersionInMemoryRepository implements
    ExternalVersionRepositoryInterface,
    TerminableInterface
{
    /**
     * @var list<ExternalVersion>|null
     */
    private ?array $versions = null;

    public function __construct(
        private readonly ExternalVersionRepositoryInterface $delegate,
    ) {}

    public function getAll(): iterable
    {
        return $this->versions ??= $this->directGetAll();
    }

    /**
     * @return list<ExternalVersion>
     */
    private function directGetAll(): array
    {
        $result = $this->delegate->getAll();

        return \iterator_to_array($result, false);
    }

    public function terminate(Request $request, Response $response): void
    {
        $this->versions = null;
    }
}
