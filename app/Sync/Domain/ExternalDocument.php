<?php

declare(strict_types=1);

namespace App\Sync\Domain;

use App\Shared\Domain\AggregateRootInterface;

final class ExternalDocument implements AggregateRootInterface
{
    public function __construct(
        public ExternalDocumentId $id,
        /**
         * @var non-empty-lowercase-string
         */
        public readonly string $hash,
        /**
         * @var non-empty-string
         */
        public readonly string $name,
        public string|\Stringable $content {
            get {
                if ($this->content instanceof \Stringable) {
                    return $this->content = (string) $this->content;
                }

                return $this->content;
            }
        },
    ) {}
}
