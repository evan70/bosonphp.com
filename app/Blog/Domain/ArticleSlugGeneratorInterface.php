<?php

declare(strict_types=1);

namespace App\Blog\Domain;

use App\Shared\Domain\Slug\SlugGeneratorInterface;

/**
 * @template-extends SlugGeneratorInterface<Article>
 */
interface ArticleSlugGeneratorInterface extends
    SlugGeneratorInterface {}
