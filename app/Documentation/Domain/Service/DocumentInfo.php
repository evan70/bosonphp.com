<?php

declare(strict_types=1);

namespace App\Documentation\Domain\Service;

final readonly class DocumentInfo extends PageInfo
{
    /**
     * @param non-empty-lowercase-string $hash
     */
    public function __construct(
        string $hash,
        /**
         * @var non-empty-string
         */
        public string $path,
    ) {
        parent::__construct($hash);
    }
}
