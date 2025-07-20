<?php

declare(strict_types=1);

namespace App\Documentation\Domain\Category\Event;

use App\Shared\Domain\Bus\EventId;

abstract readonly class CategoryEvent
{
    public function __construct(
        /**
         * @var non-empty-string
         */
        public string $version,
        /**
         * @var non-empty-string
         */
        public string $name,
        public EventId $id = new EventId(),
    ) {}
}
