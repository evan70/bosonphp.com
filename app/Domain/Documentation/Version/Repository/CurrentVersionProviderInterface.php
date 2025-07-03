<?php

declare(strict_types=1);

namespace App\Domain\Documentation\Version\Repository;

use App\Domain\Documentation\Version\Version;

interface CurrentVersionProviderInterface
{
    public function findLatest(): ?Version;
}
