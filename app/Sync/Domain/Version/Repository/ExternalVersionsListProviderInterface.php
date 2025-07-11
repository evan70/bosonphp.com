<?php

declare(strict_types=1);

namespace App\Sync\Domain\Version\Repository;

use App\Sync\Domain\Version\ExternalVersion;

interface ExternalVersionsListProviderInterface
{
    /**
     * @return iterable<array-key, ExternalVersion>
     */
    public function getAll(): iterable;
}
