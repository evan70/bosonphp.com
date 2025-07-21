<?php

declare(strict_types=1);

namespace App\Documentation\Domain\Version\Service;

/**
 * Value object representing external version information for synchronization.
 */
final readonly class VersionInfo
{
    public function __construct(
        /**
         * Hash of the version (e.g., commit hash)
         *
         * @var non-empty-lowercase-string
         */
        public string $hash,
        /**
         * Name of the version (e.g., 'v1.0')
         *
         * @var non-empty-string
         */
        public string $name,
    ) {}
}
