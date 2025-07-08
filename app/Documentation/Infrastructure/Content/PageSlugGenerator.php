<?php

declare(strict_types=1);

namespace App\Documentation\Infrastructure\Content;

use App\Documentation\Domain\Page;
use App\Documentation\Domain\PageSlugGeneratorInterface;
use App\Infrastructure\Content\SlugGenerator;

/**
 * @api
 *
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal App\Documentation\Infrastructure\Content
 *
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
