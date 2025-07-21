<?php

declare(strict_types=1);

namespace App\Documentation\Domain\Version\Service\VersionsChangeSetComputer;

use App\Documentation\Domain\Version\Event\VersionEvent;
use App\Documentation\Domain\Version\Service\VersionInfo;
use App\Documentation\Domain\Version\Version;

/**
 * Provides version change computation strategies (create, update, etc).
 */
interface VersionsComputerInterface
{
    /**
     * Processes version changes between system and external data.
     *
     * @param array<non-empty-string, Version> $existing Existing versions in the system
     * @param array<non-empty-string, VersionInfo> $updated External version data
     *
     * @return iterable<Version, VersionEvent> Pairs of versions and their events
     */
    public function process(array $existing, array $updated): iterable;
}
