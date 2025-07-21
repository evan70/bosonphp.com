<?php

declare(strict_types=1);

namespace App\Sync\Domain\Repository;

use App\Sync\Domain\ExternalDocument;
use App\Sync\Domain\ExternalPage;
use App\Sync\Domain\Version\ExternalVersion;

interface ExternalPageReferencesListProviderInterface
{
    /**
     * @param non-empty-string|ExternalVersion $version
     *
     * @return iterable<array-key, ExternalPage>
     */
    public function getAll(string|ExternalVersion $version): iterable;
}
