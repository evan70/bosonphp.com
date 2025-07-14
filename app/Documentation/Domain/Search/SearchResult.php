<?php

declare(strict_types=1);

namespace App\Documentation\Domain\Search;

use App\Documentation\Domain\PageId;

final readonly class SearchResult
{
    public function __construct(
        public PageId $id,
        public float $rank,
    ) {}
}
