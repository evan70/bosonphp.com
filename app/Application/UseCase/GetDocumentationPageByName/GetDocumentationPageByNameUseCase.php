<?php

declare(strict_types=1);

namespace App\Application\UseCase\GetDocumentationPageByName;

use App\Application\Query\GetDocumentationVersionByNameQuery;
use App\Application\UseCase\GetDocumentationPageByName\Exception\PageNotFoundException;
use App\Application\UseCase\GetDocumentationVersionByName\GetDocumentationVersionByNameResult;
use App\Domain\Documentation\Repository\PageByNameProviderInterface;
use App\Domain\Shared\Bus\QueryBusInterface;

final readonly class GetDocumentationPageByNameUseCase
{
    public function __construct(
        private PageByNameProviderInterface $pages,
        private QueryBusInterface $queries,
    ) {}

    public function getPage(string $name, ?string $version): GetDocumentationPageByNameResult
    {
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
