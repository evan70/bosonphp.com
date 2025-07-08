<?php

declare(strict_types=1);

namespace App\Blog\Domain\Category;

use App\Blog\Domain\Category\Repository\ArticleCategoryBySlugProviderInterface;
use App\Blog\Domain\Category\Repository\ArticleCategoryListProviderInterface;
use Doctrine\Persistence\ObjectRepository;

/**
 * @template-extends ObjectRepository<Category>
 */
interface CategoryRepositoryInterface extends
    ArticleCategoryListProviderInterface,
    ArticleCategoryBySlugProviderInterface,
    ObjectRepository {}
