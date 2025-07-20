<?php

declare(strict_types=1);

namespace App\Documentation\Domain\Version\Service;

use App\Documentation\Domain\Version\Event\VersionDisabled;
use App\Documentation\Domain\Version\Event\VersionEnabled;
use App\Documentation\Domain\Version\Event\VersionEvent;
use App\Documentation\Domain\Version\Event\VersionUpdated;
use App\Documentation\Domain\Version\Service\VersionsComputer\ComputedVersionsResult;
use App\Documentation\Domain\Version\Service\VersionsComputer\ExternalVersionInfo;
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
    /**
     * Computes which versions need to be updated or disabled based on external data.
     *
     * This method compares existing versions with external version data and identifies:
     * - Versions that need hash updates
     * - Hidden versions that need to be enabled
     * - Versions that need to be disabled (no longer in external data)
     *
     * @param iterable<mixed, Version> $existing Existing versions in the system
     * @param iterable<mixed, ExternalVersionInfo> $updated External version data to compare against
     *
     * @return ComputedVersionsResult Result containing updated versions to persist and update events
     */
    public function compute(iterable $existing, iterable $updated): ComputedVersionsResult
    {
        $events = [];
        $versions = [];

        foreach ($this->process($existing, $updated) as $entity => $event) {
            $events[] = $event;
            $versions[$entity->name] = $entity;
        }

        return new ComputedVersionsResult(
            versions: \array_values($versions),
            events: $events,
        );
    }

    /**
     * Groups external version information by name for efficient lookup.
     *
     * This method creates an associative array where the key is the version name
     * and the value is the ExternalVersionInfo. This allows for O(1) lookup when
     * checking if a version exists in external data.
     *
     * @param iterable<mixed, ExternalVersionInfo> $versions External version data to group
     *
     * @return array<non-empty-string, ExternalVersionInfo> External version data indexed by name
     */
    protected function externalVersionInfoGroupByName(iterable $versions): array
    {
        $result = [];

        foreach ($versions as $info) {
            $result[$info->name] = $info;
        }

        return $result;
    }

    /**
     * Processes existing versions to determine which need updates or should be disabled.
     *
     * This method iterates through existing versions and checks if each version
     * exists in external data. If it exists, it processes updates; if not, it
     * processes disabling the version.
     *
     * @param iterable<mixed, Version> $existing Existing versions in the system
     * @param iterable<mixed, ExternalVersionInfo> $updated External version data to compare against
     *
     * @return iterable<Version, VersionEvent> Pairs of updated versions and their events
     */
    private function process(iterable $existing, iterable $updated): iterable
    {
        $externalVersionInfoIndex = $this->externalVersionInfoGroupByName($updated);

        foreach ($existing as $version) {
            // Fetch updated INFO from index
            $updatedVersionInfo = $externalVersionInfoIndex[$version->name] ?? null;

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
     * @param ExternalVersionInfo $info External version data for comparison
     *
     * @return iterable<Version, VersionEvent> Updated version and its events
     */
    private function processExisting(Version $version, ExternalVersionInfo $info): iterable
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
