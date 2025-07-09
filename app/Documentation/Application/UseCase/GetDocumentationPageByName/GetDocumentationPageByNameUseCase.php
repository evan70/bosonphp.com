<?php

declare(strict_types=1);

namespace App\Documentation\Application\UseCase\GetDocumentationPageByName;

use App\Documentation\Application\UseCase\GetDocumentationVersionByName\GetDocumentationVersionByNameQuery;
use App\Documentation\Application\UseCase\GetDocumentationPageByName\Exception\PageNotFoundException;
use App\Documentation\Application\UseCase\GetDocumentationVersionByName\GetDocumentationVersionByNameResult;
use App\Documentation\Domain\Repository\PageByNameProviderInterface;
use App\Shared\Domain\Bus\QueryBusInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(bus: 'query.bus', method: 'getPage')]
final readonly class GetDocumentationPageByNameUseCase
{
    public function __construct(
        private PageByNameProviderInterface $pages,
        private QueryBusInterface $queries,
    ) {}

    public function getPage(GetDocumentationPageByNameQuery $query): GetDocumentationPageByNameResult
    {
        $name = $query->name;
        $version = $query->version;

        /** @var GetDocumentationVersionByNameResult $result */
        $result = $this->queries->get(new GetDocumentationVersionByNameQuery($version));

        $page = $this->pages->findByName($result->version, $name)
            ?? throw new PageNotFoundException();

        return new GetDocumentationPageByNameResult(
            version: $result->version,
            categories: $result->version->categories,
            page: $page,
        );
    }
}
