<?php

declare(strict_types=1);

namespace App\Blog\Domain;

use App\Blog\Domain\Repository\ArticleBySlugProviderInterface;
use App\Blog\Domain\Repository\ArticlePaginateProviderInterface;
use Doctrine\Persistence\ObjectRepository;

/**
 * @template-extends ObjectRepository<Article>
 */
interface ArticleRepositoryInterface extends
    ArticlePaginateProviderInterface,
    ArticleBySlugProviderInterface,
    ObjectRepository {}
