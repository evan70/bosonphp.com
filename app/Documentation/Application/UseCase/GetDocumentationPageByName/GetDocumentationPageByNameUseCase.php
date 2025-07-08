<?php

declare(strict_types=1);

namespace App\Documentation\Application\UseCase\GetDocumentationPageByName;

use App\Documentation\Application\Query\GetDocumentationVersionByNameQuery;
use App\Documentation\Application\UseCase\GetDocumentationPageByName\Exception\PageNotFoundException;
use App\Documentation\Application\UseCase\GetDocumentationVersionByName\GetDocumentationVersionByNameResult;
use App\Documentation\Domain\Repository\PageByNameProviderInterface;
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
