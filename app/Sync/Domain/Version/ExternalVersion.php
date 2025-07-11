<?php

declare(strict_types=1);

namespace App\Sync\Domain\Version;

final readonly class ExternalVersion
{
    public function __construct(
        /**
         * @var non-empty-string
         */
        public string $name,
        /**
         * @var non-empty-lowercase-string
         */
        public string $hash,
    ) {}
}
