<?php

declare(strict_types=1);

namespace App\Domain\Article;

use App\Domain\Article\Repository\ArticleBySlugProviderInterface;
use App\Domain\Article\Repository\ArticlePaginateProviderInterface;
use Doctrine\Persistence\ObjectRepository;

/**
 * @template-extends ObjectRepository<Article>
 */
interface ArticleRepositoryInterface extends
    ArticlePaginateProviderInterface,
    ArticleBySlugProviderInterface,
    ObjectRepository {}
