<?php

declare(strict_types=1);

namespace App\Documentation\Application\Output\Page;

abstract readonly class PageOutput
{
    public function __construct(
        /**
         * @var non-empty-string
         */
        public string $title,
        /**
         * @var non-empty-string
         */
        public string $uri,
        public PageTypeOutput $type,
    ) {}
}
