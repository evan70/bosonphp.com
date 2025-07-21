<?php

declare(strict_types=1);

namespace App\Documentation\Domain\Version\Service\VersionsChangeSetComputer;

use App\Documentation\Domain\Version\Event\VersionCreated;
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
    public function process(array $existing, array $updated): iterable
    {
        foreach ($updated as $info) {
            // Fetch stored entity from index
            $existingVersion = $existing[$info->name] ?? null;

            // Skip in case of version is present
            if ($existingVersion !== null) {
                continue;
            }

            // Actualize index: If there are duplicate versions
            // to update, they will NOT be re-created.
            $existingVersion = $existing[$info->name] = new Version(
                name: $info->name,
                hash: $info->hash,
            );

            // Create an entity
            yield $existingVersion => new VersionCreated($info->name);
        }
    }
}
