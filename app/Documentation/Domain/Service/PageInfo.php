<?php

declare(strict_types=1);

namespace App\Documentation\Domain\Service;

abstract readonly class PageInfo
{
    public function __construct(
        /**
         * @var non-empty-lowercase-string
         */
        public string $hash,
        /**
         * @var int<0, max>|null
         */
        public ?int $order = null,
    ) {}
}
