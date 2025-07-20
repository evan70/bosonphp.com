<?php

declare(strict_types=1);

namespace App\Documentation\Domain\Version\Service;

use App\Documentation\Domain\Version\Service\VersionsComputer\ComputedVersionsResult;
use App\Documentation\Domain\Version\Service\VersionsComputer\ExternalVersionInfo;
use App\Documentation\Domain\Version\Version;

/**
 * Abstract base class for version computation services.
 */
abstract readonly class VersionsComputer
{
    /**
     * Computes version changes based on existing and external version data.
     *
     * This method analyzes the differences between existing versions in the system
     * and external version data to determine what changes need to be made.
     *
     * @param iterable<mixed, Version> $existing Existing versions in the system
     * @param iterable<mixed, ExternalVersionInfo> $updated External version data to compare against
     *
     * @return ComputedVersionsResult Result containing versions to persist and events to dispatch
     */
    abstract public function compute(iterable $existing, iterable $updated): ComputedVersionsResult;
}
