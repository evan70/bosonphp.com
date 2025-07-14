<?php

declare(strict_types=1);

namespace App\Search\Application\UseCase\GetDocumentationSearchResults;

use App\Documentation\Application\UseCase\GetVersionByName\GetVersionByNameOutput;
use App\Documentation\Application\UseCase\GetVersionByName\GetVersionByNameQuery;
use App\Search\Application\Output\SearchResultsListOutput;
use App\Search\Domain\Repository\SearchByOccurrenceProviderInterface;
use App\Shared\Domain\Bus\QueryBusInterface;
use App\Shared\Domain\Bus\QueryId;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(bus: 'query.bus')]
final readonly class GetDocumentationSearchResultsUseCase
{
    public function __construct(
        private SearchByOccurrenceProviderInterface $searchByOccurrenceProvider,
        private QueryBusInterface $queries,
    ) {}

    public function __invoke(GetDocumentationSearchResultsQuery $query): GetDocumentationSearchResultsOutput
    {
        /** @var GetVersionByNameOutput $version */
        $version = $this->queries->get(new GetVersionByNameQuery(
            version: $query->version,
            id: QueryId::createFrom($query->id),
        ));

        $queryValue = \trim($query->query);

        if ($queryValue === '') {
            return new GetDocumentationSearchResultsOutput(
                version: $version->version->name,
            );
        }

        $items = $this->searchByOccurrenceProvider->search(
            version: $version->version->name,
            query: $queryValue,
        );

        return new GetDocumentationSearchResultsOutput(
            version: $version->version->name,
            query: $queryValue,
            results: SearchResultsListOutput::fromSearchResults($items),
        );
    }
}
