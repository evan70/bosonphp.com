<?php

declare(strict_types=1);

namespace App\Domain\Documentation\Version\Repository;

use App\Domain\Documentation\Version\Version;

interface VersionsListProviderInterface
{
    /**
     * @return iterable<array-key, Version>
     */
    public function getAll(): iterable;
}
