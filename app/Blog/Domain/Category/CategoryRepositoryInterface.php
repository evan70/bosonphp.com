<?php

declare(strict_types=1);

namespace App\Blog\Domain\Category;

use App\Blog\Domain\Category\Repository\CategoriesListProviderInterface;
use App\Blog\Domain\Category\Repository\CategoryByUriProviderInterface;
use Doctrine\Persistence\ObjectRepository;

/**
 * @template-extends ObjectRepository<Category>
 */
interface CategoryRepositoryInterface extends
    CategoriesListProviderInterface,
    CategoryByUriProviderInterface,
    ObjectRepository {}
