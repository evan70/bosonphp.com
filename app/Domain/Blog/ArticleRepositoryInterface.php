<?php

declare(strict_types=1);

namespace App\Domain\Blog;

use App\Domain\Blog\Repository\ArticleBySlugProviderInterface;
use App\Domain\Blog\Repository\ArticlePaginateProviderInterface;
use Doctrine\Persistence\ObjectRepository;

/**
 * @template-extends ObjectRepository<Article>
 */
interface ArticleRepositoryInterface extends
    ArticlePaginateProviderInterface,
    ArticleBySlugProviderInterface,
    ObjectRepository {}
