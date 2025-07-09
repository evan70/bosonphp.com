<?php

declare(strict_types=1);

namespace App\Blog\Application\UseCase\GetArticlesList;

use App\Blog\Application\Output\Article\ShortArticlesListOutput;
use App\Blog\Application\Output\Category\CategoryOutput;

final readonly class GetArticlesListOutput
{
    public function __construct(
        /**
         * @var int<1, 2147483647>
         */
        public int $page,
        public ShortArticlesListOutput $articles,
        public ?CategoryOutput $category = null,
    ) {}
}
