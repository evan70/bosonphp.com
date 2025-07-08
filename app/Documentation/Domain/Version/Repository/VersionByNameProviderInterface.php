<?php

declare(strict_types=1);

namespace App\Documentation\Domain\Version\Repository;

use App\Documentation\Domain\Version\Version;

interface VersionByNameProviderInterface
{
    public function findVersionByName(string $name): ?Version;
}
