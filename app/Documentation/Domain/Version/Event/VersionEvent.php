<?php

declare(strict_types=1);

namespace App\Documentation\Domain\Version\Event;

use App\Shared\Domain\Bus\EventId;

abstract readonly class VersionEvent
{
    public function __construct(
        /**
         * @var non-empty-string
         */
        public string $name,
        public EventId $id = new EventId(),
    ) {}
}
