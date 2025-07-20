<?php

declare(strict_types=1);

namespace App\Documentation\Domain\Version\Service\VersionsComputer;

/**
 * Value object representing external version information.
 *
 * This value object encapsulates data about a version that comes from
 * an external source (e.g., Git repository, external API). It contains
 * the version name and hash for comparison with existing versions in
 * the system.
 */
final readonly class ExternalVersionInfo
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
