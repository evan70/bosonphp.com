<?php

declare(strict_types=1);

namespace App\Sync\Domain\Version;

use App\Shared\Domain\Id\Hash64Id;

final readonly class ExternalVersionId extends Hash64Id
{
    /**
     * @param non-empty-string $version
     */
    public static function createFromName(string $version): static
    {
        return self::createFromString($version);
    }
}
