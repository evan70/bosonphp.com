<?php

declare(strict_types=1);

namespace App\Documentation\Domain\Version\Service\VersionsChangeSetComputer;

use App\Documentation\Domain\Version\Event\VersionCreated;
use App\Documentation\Domain\Version\Version;

/**
 * Computes which versions need to be created based on external data.
 */
final readonly class VersionsToCreateComputer implements VersionsComputerInterface
{
    /**
     * Determines which versions are missing in the system and should be created.
     */
    public function process(array $existing, array $updated): iterable
    {
        foreach ($updated as $info) {
            // Fetch stored entity from index
            $existingVersion = $existing[$info->name] ?? null;

            // Skip in case of version is present
            if ($existingVersion !== null) {
                continue;
            }

            // Create an entity
            yield new Version($info->name, hash: $info->hash)
                => new VersionCreated($info->name);
        }
    }
}
