<?php

declare(strict_types=1);

namespace App\Domain\Blog;

use App\Domain\Shared\Content\SlugGeneratorInterface;

/**
 * @template-extends SlugGeneratorInterface<Article>
 */
interface ArticleSlugGeneratorInterface extends
    SlugGeneratorInterface {}
