<?php

declare(strict_types=1);

namespace App\Sync\Domain;

final class ExternalLink extends ExternalPage
{
    /**
     * @param non-empty-lowercase-string $hash
     */
    public function __construct(
        ExternalPageId $id,
        string $hash,
        /**
         * @var non-empty-string
         */
        public readonly string $uri,
    ) {
        parent::__construct($id, $hash);
    }
}
