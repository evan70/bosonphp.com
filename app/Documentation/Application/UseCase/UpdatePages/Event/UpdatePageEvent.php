<?php

declare(strict_types=1);

namespace App\Documentation\Application\UseCase\UpdatePages\Event;

abstract readonly class UpdatePageEvent
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
        public string $name,
        /**
         * @var non-empty-string
         */
        public string $title,
        public string $content,
    ) {}
}
