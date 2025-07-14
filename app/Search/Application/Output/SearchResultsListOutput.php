<?php

declare(strict_types=1);

namespace App\Search\Application\Output;

use App\Search\Domain\SearchResult;
use App\Shared\Application\Output\CollectionOutput;

/**
 * @template-extends CollectionOutput<SearchResultOutput>
 */
final class SearchResultsListOutput extends CollectionOutput
{
    /**
     * @param iterable<mixed, SearchResult> $results
     */
    public static function fromSearchResults(iterable $results): self
    {
        $mapped = [];

        foreach ($results as $result) {
            $mapped[] = SearchResultOutput::fromSearchResult($result);
        }

        return new self($mapped);
    }
}
