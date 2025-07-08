<?php

declare(strict_types=1);

namespace App\Blog\Application\UseCase\GetArticlesList;

use App\Blog\Domain\Article;
use App\Blog\Domain\Category\Category;
use Doctrine\ORM\Tools\Pagination\Paginator;

final readonly class GetArticlesListResult
{
    public function __construct(
        /**
         * @var int<1, 2147483647>
         */
        public int       $page,
        /**
         * @var Paginator<Article>
         */
        public Paginator $articles,
        public ?Category $category = null,
    ) {}
}
