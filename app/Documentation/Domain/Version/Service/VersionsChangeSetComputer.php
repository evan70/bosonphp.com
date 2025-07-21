<?php

declare(strict_types=1);

namespace App\Documentation\Domain\Version\Service;

use App\Documentation\Domain\Version\Service\VersionsChangeSetComputer\VersionsToCreateComputer;
use App\Documentation\Domain\Version\Service\VersionsChangeSetComputer\VersionsToUpdateComputer;
use App\Documentation\Domain\Version\Version;

final readonly class VersionsChangeSetComputer
{
    public function __construct(
        private VersionsToUpdateComputer $updates,
        private VersionsToCreateComputer $creations,
    ) {}

    /**
     * Groups external version information by name for efficient lookup.
     *
     * This method creates an associative array where the key is the version name
     * and the value is the ExternalVersionInfo. This allows for O(1) lookup when
     * checking if a version exists in external data.
     *
     * @param iterable<mixed, VersionInfo> $versions External version data to group
     *
     * @return array<non-empty-string, VersionInfo> External version data indexed by name
     */
    private function versionInfosGroupByName(iterable $versions): array
    {
        $result = [];

        foreach ($versions as $info) {
            $result[$info->name] = $info;
        }

        \ksort($result);

        return $result;
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
    private function versionsGroupByName(iterable $versions): array
    {
        $result = [];

        foreach ($versions as $entity) {
            $result[$entity->name] = $entity;
        }

        \ksort($result);

        return $result;
    }

    /**
     * @param iterable<mixed, Version> $existing Existing versions in the system
     * @param iterable<mixed, VersionInfo> $updated external version data to
     *        compare against
     */
    public function compute(iterable $existing, iterable $updated): VersionsChangePlan
    {
        $oldVersionsIndex = $this->versionsGroupByName($existing);
        $newVersionsIndex = $this->versionInfosGroupByName($updated);

        $createdVersions = [];
        $updatedVersions = [];
        $events = [];

        foreach ($this->updates->process($oldVersionsIndex, $newVersionsIndex) as $entity => $event) {
            $updatedVersions[$entity->name] = $entity;
            $events[] = $event;
        }

        foreach ($this->creations->process($oldVersionsIndex, $newVersionsIndex) as $entity => $event) {
            $createdVersions[$entity->name] = $entity;
            $events[] = $event;
        }

        return new VersionsChangePlan(
            updated: $updatedVersions,
            created: $createdVersions,
            events: $events,
        );
    }
}
