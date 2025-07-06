<?php

declare(strict_types=1);

namespace App\Application\Query\Handler;

use App\Application\Query\GetDocumentationVersionByNameQuery;
use App\Application\UseCase\GetDocumentationVersionByName\GetDocumentationVersionByNameResult;
use App\Application\UseCase\GetDocumentationVersionByName\GetDocumentationVersionByNameUseCase;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(bus: 'query.bus')]
final readonly class GetDocumentationVersionByNameHandler
{
    public function __construct(
        private GetDocumentationVersionByNameUseCase $workflow,
    ) {}

    public function __invoke(GetDocumentationVersionByNameQuery $query): GetDocumentationVersionByNameResult
    {
        return $this->workflow->getVersion(
            version: $query->version,
        );
    }
}
