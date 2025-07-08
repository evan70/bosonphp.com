<?php

declare(strict_types=1);

namespace App\Documentation\Application\Query\Handler;

use App\Documentation\Application\Query\GetDocumentationPageByNameQuery;
use App\Documentation\Application\UseCase\GetDocumentationPageByName\GetDocumentationPageByNameResult;
use App\Documentation\Application\UseCase\GetDocumentationPageByName\GetDocumentationPageByNameUseCase;
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
