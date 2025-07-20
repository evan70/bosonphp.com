<?php

declare(strict_types=1);

namespace App\Documentation\Infrastructure\Listener;

use App\Documentation\Domain\Category\Event\CategoryCreated;
use App\Documentation\Domain\Category\Event\CategoryEvent;
use App\Documentation\Domain\Category\Event\CategoryRemoved;
use App\Documentation\Domain\Category\Event\CategoryUpdated;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

/**
 * @api
 *
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal App\Documentation\Infrastructure\Listener
 */
#[AsEventListener(event: CategoryCreated::class)]
#[AsEventListener(event: CategoryRemoved::class)]
#[AsEventListener(event: CategoryUpdated::class)]
final readonly class OnCategoryChangedListener
{
    public function __construct(
        private TagAwareCacheInterface $cache,
    ) {}

    public function __invoke(CategoryEvent $event): void
    {
        $this->cache->invalidateTags(['doc.category']);
    }
}
