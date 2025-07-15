<?php

declare(strict_types=1);

namespace App\Sync\Domain;

use App\Shared\Domain\Id\Hash64Id;

final readonly class ExternalDocumentId extends Hash64Id
{
    /**
     * @param non-empty-string $version
     * @param non-empty-string $path
     */
    public static function createFromVersionAndPath(string $version, string $path): static
    {
        return self::createFromString($version . ':' . $path);
    }
}
