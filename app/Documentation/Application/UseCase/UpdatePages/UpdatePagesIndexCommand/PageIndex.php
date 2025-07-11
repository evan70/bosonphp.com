<?php

declare(strict_types=1);

namespace App\Documentation\Application\UseCase\UpdatePages\UpdatePagesIndexCommand;

final readonly class PageIndex
{
    public function __construct(
        /**
         * @var non-empty-lowercase-string
         */
        public string $hash,
        /**
         * @var non-empty-string
         */
        public string $name,
    ) {}
}
