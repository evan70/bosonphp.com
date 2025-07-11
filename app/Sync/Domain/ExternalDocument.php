<?php

declare(strict_types=1);

namespace App\Sync\Domain;

final class ExternalDocument
{
    public function __construct(
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
