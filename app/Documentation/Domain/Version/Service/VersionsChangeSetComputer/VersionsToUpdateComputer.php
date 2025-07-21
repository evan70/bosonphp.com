<?php

declare(strict_types=1);

namespace App\Documentation\Domain\Version\Service\VersionsChangeSetComputer;

use App\Documentation\Domain\Version\Event\VersionDisabled;
use App\Documentation\Domain\Version\Event\VersionEnabled;
use App\Documentation\Domain\Version\Event\VersionEvent;
use App\Documentation\Domain\Version\Event\VersionUpdated;
use App\Documentation\Domain\Version\Service\VersionInfo;
use App\Documentation\Domain\Version\Version;

/**
 * Domain service responsible for computing which versions need to be updated or disabled.
 *
 * This service analyzes existing versions against external version data and determines
 * which versions need to be updated (hash changes, status changes) or disabled
 * (no longer present in external data). It generates appropriate events for each change.
 */
final readonly class VersionsToUpdateComputer extends VersionsComputer
{
    public function process(array $existing, array $updated): iterable
    {
        foreach ($existing as $version) {
            // Fetch updated INFO from index
            $updatedVersionInfo = $updated[$version->name] ?? null;

            if ($updatedVersionInfo !== null) {
                yield from $this->processExisting($version, $updatedVersionInfo);
            } else {
                yield from $this->processNotExisting($version);
            }
        }
    }

    /**
     * Processes an existing version that is also present in external data.
     *
     * This method handles version updates when the version exists both in the system
     * and in external data. It checks for hash changes and status changes (enabling
     * hidden versions) and generates appropriate events.
     *
     * @param Version $version Existing version to process
     * @param VersionInfo $info External version data for comparison
     *
     * @return iterable<Version, VersionEvent> Updated version and its events
     */
    private function processExisting(Version $version, VersionInfo $info): iterable
    {
        // Skip in case of hash is equals to stored one
        if ($version->hash === $info->hash) {
            return;
        }

        // Enable Version in case of it was hidden
        if ($version->isHidden) {
            $version->enable();

            yield $version => new VersionEnabled($version->name);
        }

        // Actualize Version`s hash
        $version->hash = $info->hash;

        yield $version => new VersionUpdated($version->name);
    }

    /**
     * Processes an existing version that is no longer present in external data.
     *
     * This method handles version disabling when a version exists in the system
     * but is no longer present in external data. It disables the version and
     * generates appropriate events.
     *
     * @param Version $version Existing version to process
     *
     * @return iterable<Version, VersionEvent> Disabled version and its events
     */
    private function processNotExisting(Version $version): iterable
    {
        // Skip in case of version is hidden
        if ($version->isHidden) {
            return;
        }

        $version->disable();

        yield $version => new VersionDisabled($version->name);
        yield $version => new VersionUpdated($version->name);
    }
}
