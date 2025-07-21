<?php

declare(strict_types=1);

namespace App\Sync\Domain;

use App\Shared\Domain\AggregateRootInterface;

abstract class ExternalPage implements AggregateRootInterface
{
    public function __construct(
        public ExternalPageId $id,
        /**
         * @var non-empty-lowercase-string
         */
        public readonly string $hash,
    ) {}
}
