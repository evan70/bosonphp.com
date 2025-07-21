<?php

declare(strict_types=1);

namespace App\Documentation\Domain\Version\Service;

use App\Documentation\Domain\Version\Event\VersionCreated;
use App\Documentation\Domain\Version\Event\VersionEvent;
use App\Documentation\Domain\Version\Service\VersionsComputer\ComputedVersionsResult;
use App\Documentation\Domain\Version\Service\VersionsComputer\VersionInfo;
use App\Documentation\Domain\Version\Version;

/**
 * Domain service responsible for computing which versions need to be created.
 *
 * This service analyzes external version data and determines which versions
 * don't exist in the system and need to be created. It generates the appropriate
 * VersionCreated events for each new version.
 */
final readonly class VersionsToCreateComputer extends VersionsComputer
{
    /**
     * Computes which versions need to be created based on external data.
     *
     * This method compares existing versions with external version data
     * and identifies versions that exist externally but not in the system.
     * For each such version, it creates a new Version entity and generates
     * a VersionCreated event.
     *
     * @param iterable<mixed, Version> $existing Existing versions in the system
     * @param iterable<mixed, VersionInfo> $updated External version data to compare against
     *
     * @return ComputedVersionsResult Result containing new versions to persist and creation events
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
            versions: $versions,
            events: $events,
        );
    }

    /**
     * Groups versions by their name for efficient lookup.
     *
     * This method creates an associative array where the key is the version name
     * and the value is the Version entity. This allows for O(1) lookup when
     * checking if a version already exists.
     *
     * @param iterable<mixed, Version> $versions Versions to group
     *
     * @return array<non-empty-string, Version> Versions indexed by name
     */
    protected function versionGroupByName(iterable $versions): array
    {
        $result = [];

        foreach ($versions as $entity) {
            $result[$entity->name] = $entity;
        }

        return $result;
    }

    /**
     * Processes external version data to identify versions that need to be created.
     *
     * This method iterates through external version data and checks if each version
     * already exists in the system. If a version doesn't exist, it creates a new
     * Version entity and generates a VersionCreated event.
     *
     * @param iterable<mixed, Version> $existing Existing versions in the system
     * @param iterable<mixed, VersionInfo> $updated External version data to process
     *
     * @return iterable<Version, VersionEvent> Pairs of new versions and their creation events
     */
    private function process(iterable $existing, iterable $updated): iterable
    {
        $existingVersionIndex = $this->versionGroupByName($existing);

        foreach ($updated as $info) {
            // Fetch stored entity from index
            $existingVersion = $existingVersionIndex[$info->name] ?? null;

            // Skip in case of version is present
            if ($existingVersion !== null) {
                continue;
            }

            // Create an entity
            yield new Version(name: $info->name, hash: $info->hash)
                => new VersionCreated($info->name);
        }
    }
}
