<?php

declare(strict_types=1);

namespace App\Application\Query\Handler;

use App\Application\Query\GetDocumentationPageByNameQuery;
use App\Application\UseCase\GetDocumentationPageByName\GetDocumentationPageByNameResult;
use App\Application\UseCase\GetDocumentationPageByName\GetDocumentationPageByNameUseCase;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(bus: 'query.bus')]
final readonly class GetDocumentationPageByNameHandler
{
    public function __construct(
        private GetDocumentationPageByNameUseCase $workflow,
    ) {}

    public function __invoke(GetDocumentationPageByNameQuery $query): GetDocumentationPageByNameResult
    {
        return $this->workflow->getPage(
            name: $query->name,
            version: $query->version,
        );
    }
}
