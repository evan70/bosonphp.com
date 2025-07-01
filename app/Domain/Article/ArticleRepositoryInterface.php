<?php

declare(strict_types=1);

namespace App\Domain\Article;

use App\Domain\Article\Repository\ArticlePaginateProviderInterface;

interface ArticleRepositoryInterface extends
    ArticlePaginateProviderInterface {}
