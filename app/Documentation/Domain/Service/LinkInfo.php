<?php

declare(strict_types=1);

namespace App\Documentation\Domain\Service;

final readonly class LinkInfo extends PageInfo
{
    /**
     * @param non-empty-lowercase-string $hash
     */
    public function __construct(
        string $hash,
        /**
         * @var non-empty-string
         */
        public string $uri,
    ) {
        parent::__construct($hash);
    }
}
