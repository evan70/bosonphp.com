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
 * Computes which versions need to be updated.
 */
final readonly class VersionsToUpdateComputer implements VersionsComputerInterface
{
    /**
     * Determines which versions should be updated (including enable or disable).
     */
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
     * Handles update logic for a version present in both system and
     * external data.
     *
     * @return iterable<Version, VersionEvent>
     */
    private function processExisting(Version $version, VersionInfo $info): iterable
    {
        // Skip in case of hash is equals to stored one
        if ($version->hash === $info->hash) {
            return;
        }

        // Actualize Version`s hash
        $version->hash = $info->hash;

        yield $version => new VersionUpdated($version->name);
    }

    /**
     * Handles disabling logic for a version missing in external data.
     *
     * @return iterable<Version, VersionEvent>
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
