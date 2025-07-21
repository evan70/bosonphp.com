<?php

declare(strict_types=1);

namespace App\Documentation\Domain\Version\Service;

use App\Documentation\Domain\Version\Service\VersionsChangeSetComputer\VersionsToCreateComputer;
use App\Documentation\Domain\Version\Service\VersionsChangeSetComputer\VersionsToUpdateComputer;
use App\Documentation\Domain\Version\Version;

/**
 * Computes the set of changes (create, update) required to synchronize
 * system versions with external version data.
 */
final readonly class VersionsChangeSetComputer
{
    public function __construct(
        /**
         * Strategy for updating existing versions
         */
        private VersionsToUpdateComputer $updates,
        /**
         * Strategy for creating new versions
         */
        private VersionsToCreateComputer $creations,
    ) {}

    /**
     * Groups external version information by name for efficient lookup.
     *
     * @param iterable<mixed, VersionInfo> $versions
     *
     * @return array<non-empty-string, VersionInfo>
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
     * Groups system versions by their name for efficient lookup.
     *
     * @param iterable<mixed, Version> $versions
     *
     * @return array<non-empty-string, Version>
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
     * Computes the plan of changes (created, updated, events) to synchronize
     * system versions with the provided external version data.
     *
     * @param iterable<mixed, Version> $existing Existing versions in the system
     * @param iterable<mixed, VersionInfo> $updated External version data to
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
