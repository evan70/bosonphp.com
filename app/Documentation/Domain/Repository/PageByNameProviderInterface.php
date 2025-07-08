<?php

declare(strict_types=1);

namespace App\Documentation\Domain\Repository;

use App\Documentation\Domain\PageDocument;
use App\Documentation\Domain\Version\Version;

interface PageByNameProviderInterface
{
    public function findByName(Version $version, string $name): ?PageDocument;
}
