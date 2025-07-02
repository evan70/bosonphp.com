<?php

declare(strict_types=1);

namespace App\Infrastructure\Content;

use App\Domain\Documentation\Page;
use App\Domain\Documentation\PageSlugGeneratorInterface;

/**
 * @template-extends SlugGenerator<Page>
 */
final readonly class PageSlugGenerator extends SlugGenerator implements
    PageSlugGeneratorInterface
{
    public function createSlug(object $entity): string
    {
        assert($entity instanceof Page);

        return $this->createSlugByString($entity->title);
    }
}
