<?php

declare(strict_types=1);

namespace App\Blog\Domain\Category;

use App\Shared\Domain\Slug\SlugGeneratorInterface;

/**
 * @template-extends SlugGeneratorInterface<Category>
 */
interface CategorySlugGeneratorInterface extends
    SlugGeneratorInterface {}
