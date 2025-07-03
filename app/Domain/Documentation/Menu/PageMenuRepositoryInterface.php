<?php

declare(strict_types=1);

namespace App\Domain\Documentation\Menu;

use App\Domain\Documentation\Menu\Repository\PageMenuListProviderInterface;
use Doctrine\Persistence\ObjectRepository;

/**
 * @template-extends ObjectRepository<PageMenu>
 */
interface PageMenuRepositoryInterface extends
    PageMenuListProviderInterface,
    ObjectRepository {}
