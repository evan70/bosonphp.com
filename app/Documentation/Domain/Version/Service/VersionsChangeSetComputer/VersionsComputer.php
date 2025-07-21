<?php

declare(strict_types=1);

namespace App\Documentation\Domain\Version\Service\VersionsChangeSetComputer;

use App\Documentation\Domain\Version\Event\VersionEvent;
use App\Documentation\Domain\Version\Service\VersionInfo;
use App\Documentation\Domain\Version\Version;

abstract readonly class VersionsComputer
{
    /**
     * @param array<non-empty-string, Version> $existing existing versions in
     *        the system
     * @param array<non-empty-string, VersionInfo> $updated external version
     *        data to process
     *
     * @return iterable<Version, VersionEvent> Pairs of new versions and their events
     */
    abstract public function process(array $existing, array $updated): iterable;
}
