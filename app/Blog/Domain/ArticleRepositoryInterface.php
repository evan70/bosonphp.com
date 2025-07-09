<?php

declare(strict_types=1);

namespace App\Blog\Domain;

use App\Blog\Domain\Repository\ArticleByUriProviderInterface;
use App\Blog\Domain\Repository\ArticlesListPaginateProviderInterface;
use Doctrine\Persistence\ObjectRepository;

/**
 * @template-extends ObjectRepository<Article>
 */
interface ArticleRepositoryInterface extends
    ArticlesListPaginateProviderInterface,
    ArticleByUriProviderInterface,
    ObjectRepository {}
