<?php

declare(strict_types=1);

namespace App\Sync\Domain\Category;

use App\Sync\Domain\Category\Repository\ExternalCategoriesListProviderInterface;

interface ExternalCategoryRepositoryInterface extends
    ExternalCategoriesListProviderInterface {}
