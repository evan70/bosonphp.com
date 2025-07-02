<?php

declare(strict_types=1);

namespace App\Domain\Blog\Category;

use App\Domain\Shared\Content\SlugGeneratorInterface;

/**
 * @template-extends SlugGeneratorInterface<ArticleCategory>
 */
interface ArticleCategorySlugGeneratorInterface extends
    SlugGeneratorInterface {}
