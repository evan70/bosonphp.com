<?php

declare(strict_types=1);

namespace App\Documentation\Application\Query\Handler;

use App\Documentation\Application\Query\GetDocumentationCategoriesListQuery;
use App\Documentation\Application\UseCase\GetDocumentationCategoriesList\GetDocumentationCategoriesListResult;
use App\Documentation\Application\UseCase\GetDocumentationCategoriesList\GetDocumentationCategoriesListUseCase;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(bus: 'query.bus')]
final readonly class GetDocumentationCategoriesListHandler
{
    public function __construct(
        private GetDocumentationCategoriesListUseCase $workflow,
    ) {}

    public function __invoke(GetDocumentationCategoriesListQuery $query): GetDocumentationCategoriesListResult
    {
        return $this->workflow->getCategories(
            version: $query->version,
        );
    }
}
