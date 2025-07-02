<?php

declare(strict_types=1);

namespace App\Domain\Article\Category;

use App\Domain\Shared\Title\SlugGeneratorInterface;

/**
 * @template-extends SlugGeneratorInterface<ArticleCategory>
 */
interface ArticleCategorySlugGeneratorInterface extends
    SlugGeneratorInterface {}
