<?php

declare(strict_types=1);

namespace App\Domain\Blog\Category;

use App\Domain\Blog\Category\Repository\ArticleCategoryListProviderInterface;
use Doctrine\Persistence\ObjectRepository;

/**
 * @template-extends ObjectRepository<ArticleCategory>
 */
interface ArticleCategoryRepositoryInterface extends
    ArticleCategoryListProviderInterface,
    ObjectRepository {}
