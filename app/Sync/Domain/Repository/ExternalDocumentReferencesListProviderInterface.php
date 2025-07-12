<?php

declare(strict_types=1);

namespace App\Sync\Domain\Repository;

use App\Sync\Domain\ExternalDocument;
use App\Sync\Domain\Version\ExternalVersion;

interface ExternalDocumentReferencesListProviderInterface
{
    /**
     * @param non-empty-string|ExternalVersion $version
     *
     * @return iterable<array-key, ExternalDocument>
     */
    public function getAll(string|ExternalVersion $version): iterable;
}
