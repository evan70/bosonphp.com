<?php

declare(strict_types=1);

namespace App\Documentation\Domain\Category;

use App\Documentation\Domain\Category\Repository\CategoryListProviderInterface;
use Doctrine\Persistence\ObjectRepository;

/**
 * @template-extends ObjectRepository<Category>
 */
interface CategoryRepositoryInterface extends
    CategoryListProviderInterface,
    ObjectRepository {}
