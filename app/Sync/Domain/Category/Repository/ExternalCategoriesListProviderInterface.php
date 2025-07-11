<?php

declare(strict_types=1);

namespace App\Sync\Domain\Category\Repository;

use App\Sync\Domain\Category\ExternalCategory;
use App\Sync\Domain\Version\ExternalVersion;

interface ExternalCategoriesListProviderInterface
{
    /**
     * @param non-empty-string|ExternalVersion $version
     * @return iterable<array-key, ExternalCategory>
     */
    public function getAll(string|ExternalVersion $version): iterable;
}
