<?php

declare(strict_types=1);

namespace App\Documentation\Application\Query\Handler;

use App\Documentation\Application\Query\GetDocumentationVersionByNameQuery;
use App\Documentation\Application\UseCase\GetDocumentationVersionByName\GetDocumentationVersionByNameResult;
use App\Documentation\Application\UseCase\GetDocumentationVersionByName\GetDocumentationVersionByNameUseCase;
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
