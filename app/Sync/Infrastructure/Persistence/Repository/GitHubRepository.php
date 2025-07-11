<?php

declare(strict_types=1);

namespace App\Sync\Infrastructure\Persistence\Repository;

use Github\Client as GitHubClient;

abstract readonly class GitHubRepository
{
    public function __construct(
        /**
         * @var non-empty-string
         */
        protected string $owner,
        /**
         * @var non-empty-string
         */
        protected string $repository,
        protected GitHubClient $github,
    ) {}
}
