<?php

declare(strict_types=1);

namespace App\Sync\Infrastructure\Persistence\Repository;

use App\Sync\Domain\Category\ExternalCategory;
use App\Sync\Domain\Category\ExternalCategoryRepositoryInterface;
use App\Sync\Domain\Version\ExternalVersion;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\TerminableInterface;

final class ExternalCategoryInMemoryRepository implements
    ExternalCategoryRepositoryInterface,
    TerminableInterface
{
    /**
     * @var array<non-empty-string, list<ExternalCategory>>
     */
    private array $categories = [];

    public function __construct(
        private readonly ExternalCategoryRepositoryInterface $delegate,
    ) {}

    public function getAll(ExternalVersion|string $version): iterable
    {
        if ($version instanceof ExternalVersion) {
            $version = $version->name;
        }

        return $this->categories[$version] ??= $this->directGetAll($version);
    }

    /**
     * @param non-empty-string|ExternalVersion $version
     *
     * @return list<ExternalCategory>
     */
    private function directGetAll(ExternalVersion|string $version): array
    {
        $result = $this->delegate->getAll($version);

        return \iterator_to_array($result, false);
    }

    public function terminate(Request $request, Response $response): void
    {
        $this->categories = [];
    }
}
