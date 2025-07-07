<?php

declare(strict_types=1);

namespace App\Domain\Documentation\Repository;

use App\Domain\Documentation\PageDocument;
use App\Domain\Documentation\Version\Version;

interface PageByNameProviderInterface
{
    public function findByName(Version $version, string $name): ?PageDocument;
}
