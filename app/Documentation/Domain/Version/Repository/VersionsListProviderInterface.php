<?php

declare(strict_types=1);

namespace App\Documentation\Domain\Version\Repository;

use App\Documentation\Domain\Version\Version;

interface VersionsListProviderInterface
{
    /**
     * @return iterable<array-key, Version>
     */
    public function getAll(): iterable;
}
