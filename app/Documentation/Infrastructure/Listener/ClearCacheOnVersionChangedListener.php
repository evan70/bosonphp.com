<?php

declare(strict_types=1);

namespace App\Documentation\Infrastructure\Listener;

use App\Documentation\Domain\Version\Event\VersionCreated;
use App\Documentation\Domain\Version\Event\VersionDisabled;
use App\Documentation\Domain\Version\Event\VersionEnabled;
use App\Documentation\Domain\Version\Event\VersionEvent;
use App\Documentation\Domain\Version\Event\VersionUpdated;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

/**
 * @api
 *
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal App\Documentation\Infrastructure\Listener
 */
#[AsEventListener(event: VersionCreated::class)]
#[AsEventListener(event: VersionDisabled::class)]
#[AsEventListener(event: VersionEnabled::class)]
#[AsEventListener(event: VersionUpdated::class)]
final readonly class ClearCacheOnVersionChangedListener
{
    public function __construct(
        private TagAwareCacheInterface $cache,
    ) {}

    public function __invoke(VersionEvent $event): void
    {
        $this->cache->invalidateTags(['doc.version']);
    }
}
