<?php

declare(strict_types=1);

namespace App\Sync\Domain\Version;

use App\Sync\Domain\Version\Repository\ExternalVersionsListProviderInterface;

interface ExternalVersionRepositoryInterface extends
    ExternalVersionsListProviderInterface {}
