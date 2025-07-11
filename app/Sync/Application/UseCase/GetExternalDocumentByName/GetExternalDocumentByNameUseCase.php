<?php

declare(strict_types=1);

namespace App\Sync\Application\UseCase\GetExternalDocumentByName;

use App\Sync\Application\Output\ExternalDocumentOutput;
use App\Sync\Application\UseCase\GetExternalDocumentByName\Exception\DocumentNotFoundException;
use App\Sync\Domain\Repository\ExternalDocumentByNameProviderInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(bus: 'query.bus')]
final readonly class GetExternalDocumentByNameUseCase
{
    public function __construct(
        private ExternalDocumentByNameProviderInterface $pages,
    ) {}

    public function __invoke(GetExternalDocumentByNameQuery $query): GetExternalDocumentByNameOutput
    {
        $document = $this->pages->findByName($query->version, $query->path);

        if ($document === null) {
            throw new DocumentNotFoundException(\sprintf(
                'The document "%s" was not found in version "%s"',
                $query->path,
                $query->version,
            ));
        }

        return new GetExternalDocumentByNameOutput(
            document: ExternalDocumentOutput::fromExternalDocument(
                document: $document,
            ),
        );
    }
}
