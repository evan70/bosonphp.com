<?php

declare(strict_types=1);

namespace App\Documentation\Domain\Version;

use App\Documentation\Domain\Version\Repository\CurrentVersionProviderInterface;
use App\Documentation\Domain\Version\Repository\VersionByNameProviderInterface;
use App\Documentation\Domain\Version\Repository\VersionsListProviderInterface;
use Doctrine\Persistence\ObjectRepository;

/**
 * @template-extends ObjectRepository<Version>
 */
interface VersionRepositoryInterface extends
    CurrentVersionProviderInterface,
    VersionByNameProviderInterface,
    VersionsListProviderInterface,
    ObjectRepository {}
