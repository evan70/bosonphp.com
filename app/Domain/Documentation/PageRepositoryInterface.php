<?php

declare(strict_types=1);

namespace App\Domain\Documentation;

use App\Domain\Documentation\Repository\PageByNameProviderInterface;
use Doctrine\Persistence\ObjectRepository;

/**
 * @template-extends ObjectRepository<PageDocument>
 */
interface PageRepositoryInterface extends
    PageByNameProviderInterface,
    ObjectRepository {}
