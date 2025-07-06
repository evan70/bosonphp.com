<?php

declare(strict_types=1);

namespace App\Application\UseCase\GetArticlesList;

use App\Domain\Blog\Article;
use App\Domain\Blog\Category\ArticleCategory;
use Doctrine\ORM\Tools\Pagination\Paginator;

final readonly class GetArticlesListResult
{
    public function __construct(
        /**
         * @var int<1, 2147483647>
         */
        public int $page,
        /**
         * @var Paginator<Article>
         */
        public Paginator $articles,
        public ?ArticleCategory $category = null,
    ) {}
}
