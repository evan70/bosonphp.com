<?php

declare(strict_types=1);

namespace App\Domain\Documentation\Category;

use App\Domain\Documentation\Category\Repository\CategoryListProviderInterface;
use Doctrine\Persistence\ObjectRepository;

/**
 * @template-extends ObjectRepository<Category>
 */
interface CategoryRepositoryInterface extends
    CategoryListProviderInterface,
    ObjectRepository {}
