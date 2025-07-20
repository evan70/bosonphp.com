<?php

declare(strict_types=1);

namespace App\Documentation\Domain\Event;

use App\Shared\Domain\Bus\EventId;

/**
 * Base event class for all page-related events in the Documentation domain.
 * 
 * This abstract class provides common properties for page events including
 * version, category, title, URI, and event ID. All page-related domain events
 * should extend this class to ensure consistency in event structure.
 */
abstract readonly class PageEvent
{
    public function __construct(
        /**
         * @var non-empty-string
         */
        public string $version,
        /**
         * @var non-empty-string
         */
        public string $category,
        /**
         * @var non-empty-string
         */
        public string $title,
        /**
         * @var non-empty-string
         */
        public string $uri,
        public EventId $id = new EventId(),
    ) {}
}
