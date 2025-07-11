<?php

declare(strict_types=1);

namespace App\Documentation\Application\UseCase\UpdateVersionsIndex\Event;

abstract readonly class VersionEvent
{
    public function __construct(
        /**
         * @var non-empty-string
         */
        public string $version,
    ) {}
}
