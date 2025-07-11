<?php

declare(strict_types=1);

namespace App\Documentation\Application\UseCase\UpdateVersionsIndex\UpdateVersionsIndexCommand;

final readonly class IndexVersion
{
    public function __construct(
        /**
         * @var non-empty-string
         */
        public string $version,
        /**
         * @var non-empty-string
         */
        public string $hash,
    ) {}
}
