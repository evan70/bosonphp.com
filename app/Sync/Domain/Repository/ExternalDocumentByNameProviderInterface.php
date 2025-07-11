<?php

declare(strict_types=1);

namespace App\Sync\Domain\Repository;

use App\Sync\Domain\ExternalDocument;
use App\Sync\Domain\Version\ExternalVersion;

interface ExternalDocumentByNameProviderInterface
{
    /**
     * @param non-empty-string|ExternalVersion $version
     * @param non-empty-string $name
     */
    public function findByName(string|ExternalVersion $version, string $name): ?ExternalDocument;
}
