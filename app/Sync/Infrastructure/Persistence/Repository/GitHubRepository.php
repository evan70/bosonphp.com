<?php

declare(strict_types=1);

namespace App\Sync\Infrastructure\Persistence\Repository;

use Github\Client as GitHubClient;

abstract class GitHubRepository
{
    public function __construct(
        /**
         * @var non-empty-string
         */
        public private(set) string $owner,
        /**
         * @var non-empty-string
         */
        public private(set) string $repository,
        protected GitHubClient $github,
    ) {}
}
