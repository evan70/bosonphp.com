<?php

declare(strict_types=1);

namespace App\Documentation\Application\UseCase\UpdateVersions\UpdateVersionsCommand;

final readonly class VersionIndex
{
    public function __construct(
        /**
         * @var non-empty-lowercase-string
         */
        public string $hash,
        /**
         * @var non-empty-string
         */
        public string $name,
    ) {}
}
