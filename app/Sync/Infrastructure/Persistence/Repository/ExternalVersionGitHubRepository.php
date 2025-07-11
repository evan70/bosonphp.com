<?php

declare(strict_types=1);

namespace App\Sync\Infrastructure\Persistence\Repository;

use App\Sync\Domain\Version\ExternalVersion;
use App\Sync\Domain\Version\ExternalVersionRepositoryInterface;

final class ExternalVersionGitHubRepository extends GitHubRepository implements
    ExternalVersionRepositoryInterface
{
    public function getAll(): iterable
    {
        /**
         * @var list<array{
         *     name: non-empty-string,
         *     commit: array{
         *         sha: non-empty-lowercase-string,
         *         url: non-empty-string,
         *         ...
         *     },
         *     protected: bool
         * }> $result
         */
        $result = $this->github->repository()
            ->branches($this->owner, $this->repository);

        foreach ($result as $item) {
            yield new ExternalVersion(
                name: $item['name'],
                hash: $item['commit']['sha'],
            );
        }
    }
}
