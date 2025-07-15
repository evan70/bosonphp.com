<?php

declare(strict_types=1);

namespace App\Documentation\Domain\Event;

use App\Shared\Domain\Bus\EventId;

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
