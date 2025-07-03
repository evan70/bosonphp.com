<?php

declare(strict_types=1);

namespace App\Domain\Documentation\Version;

use App\Domain\Documentation\Version\Repository\CurrentVersionProviderInterface;
use App\Domain\Documentation\Version\Repository\VersionByNameProviderInterface;
use App\Domain\Documentation\Version\Repository\VersionsListProviderInterface;
use Doctrine\Persistence\ObjectRepository;

/**
 * @template-extends ObjectRepository<Version>
 */
interface VersionRepositoryInterface extends
    CurrentVersionProviderInterface,
    VersionByNameProviderInterface,
    VersionsListProviderInterface,
    ObjectRepository {}
