<?php

declare(strict_types=1);

namespace App\Documentation\Infrastructure\Listener;

use App\Documentation\Domain\Event\DocumentCreated;
use App\Documentation\Domain\Event\DocumentRemoved;
use App\Documentation\Domain\Event\DocumentUpdated;
use App\Documentation\Domain\Event\LinkCreated;
use App\Documentation\Domain\Event\LinkRemoved;
use App\Documentation\Domain\Event\LinkUpdated;
use App\Documentation\Domain\Event\PageEvent;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

/**
 * @api
 *
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal App\Documentation\Infrastructure\Listener
 */
#[AsEventListener(event: DocumentCreated::class)]
#[AsEventListener(event: DocumentRemoved::class)]
#[AsEventListener(event: DocumentUpdated::class)]
#[AsEventListener(event: LinkCreated::class)]
#[AsEventListener(event: LinkRemoved::class)]
#[AsEventListener(event: LinkUpdated::class)]
final readonly class ClearCacheOnPageChangedListener
{
    public function __construct(
        private TagAwareCacheInterface $cache,
    ) {}

    public function __invoke(PageEvent $event): void
    {
        $this->cache->invalidateTags(['doc.page']);
    }
}
