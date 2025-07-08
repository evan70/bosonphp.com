<?php

declare(strict_types=1);

namespace App\Documentation\Domain;

use App\Domain\Shared\Content\SlugGeneratorInterface;

/**
 * @template-extends SlugGeneratorInterface<Page>
 */
interface PageSlugGeneratorInterface extends
    SlugGeneratorInterface {}
