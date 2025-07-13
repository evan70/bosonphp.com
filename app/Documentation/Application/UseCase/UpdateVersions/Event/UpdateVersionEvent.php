<?php

declare(strict_types=1);

namespace App\Documentation\Application\UseCase\UpdateVersions\Event;

use App\Shared\Domain\Bus\EventId;

abstract readonly class UpdateVersionEvent
{
    public function __construct(
        /**
         * @var non-empty-string
         */
        public string $name,
        public EventId $id = new EventId(),
    ) {}
}
