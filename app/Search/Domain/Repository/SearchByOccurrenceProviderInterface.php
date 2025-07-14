<?php

declare(strict_types=1);

namespace App\Search\Domain\Repository;

use App\Search\Domain\SearchResult;

interface SearchByOccurrenceProviderInterface
{
    public const int DEFAULT_SEARCH_LIMIT = 10;

    /**
     * @param int<1, max> $limit
     *
     * @return iterable<array-key, SearchResult>
     */
    public function search(string $version, string $query, int $limit = self::DEFAULT_SEARCH_LIMIT): iterable;
}
