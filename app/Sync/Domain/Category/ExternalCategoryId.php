<?php

declare(strict_types=1);

namespace App\Sync\Domain\Category;

use App\Shared\Domain\Id\Hash64Id;

final readonly class ExternalCategoryId extends Hash64Id
{
    /**
     * @param non-empty-string $version
     * @param non-empty-string $name
     */
    public static function createFromVersionAndName(string $version, string $name): static
    {
        return self::createFromString($version . ':' . $name);
    }
}
