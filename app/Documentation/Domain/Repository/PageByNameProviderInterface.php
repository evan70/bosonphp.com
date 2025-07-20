<?php

declare(strict_types=1);

namespace App\Documentation\Domain\Repository;

use App\Documentation\Domain\Document;

interface PageByNameProviderInterface
{
    public function findByName(string $version, string $name): ?Document;
}
