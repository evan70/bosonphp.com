<?php

declare(strict_types=1);

namespace App\Documentation\Domain\Service;

final readonly class DocumentInfo extends PageInfo
{
    /**
     * @param non-empty-lowercase-string $hash
     * @param int<0, max>|null $order
     */
    public function __construct(
        string $hash,
        /**
         * @var non-empty-string
         */
        public string $path,
        ?int $order = null,
    ) {
        parent::__construct($hash, $order);
    }
}
