<?php

declare(strict_types=1);

namespace App\Documentation\Application\UseCase\GetDocumentationCategoriesList;

use App\Documentation\Application\UseCase\GetDocumentationVersionByName\GetDocumentationVersionByNameQuery;
use App\Documentation\Application\UseCase\GetDocumentationVersionByName\GetDocumentationVersionByNameResult;
use App\Shared\Domain\Bus\QueryBusInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(bus: 'query.bus', method: 'getCategories')]
final readonly class GetDocumentationCategoriesListUseCase
{
    public function __construct(
        private QueryBusInterface $queries,
    ) {}

    public function getCategories(GetDocumentationCategoriesListQuery $query): GetDocumentationCategoriesListResult
    {
        $version = $query->version;

        /** @var GetDocumentationVersionByNameResult $result */
        $result = $this->queries->get(new GetDocumentationVersionByNameQuery($version));

        return new GetDocumentationCategoriesListResult(
            version: $result->version,
            categories: $result->version->categories,
        );
    }
}
