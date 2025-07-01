<?php

declare(strict_types=1);

namespace App\Domain\Article;

use App\Domain\Shared\Title\SlugGeneratorInterface;

/**
 * @template-extends SlugGeneratorInterface<Article>
 */
interface ArticleSlugGeneratorInterface extends
    SlugGeneratorInterface {}
