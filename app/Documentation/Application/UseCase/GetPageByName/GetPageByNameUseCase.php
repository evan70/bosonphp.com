<?php

declare(strict_types=1);

namespace App\Documentation\Application\UseCase\GetPageByName;

use App\Documentation\Application\Output\Category\CategoryOutput;
use App\Documentation\Application\Output\Page\DocumentOutput;
use App\Documentation\Application\Output\Version\VersionOutput;
use App\Documentation\Application\UseCase\GetPageByName\Exception\PageNotFoundException;
use App\Documentation\Application\UseCase\GetVersionByName\GetVersionByNameOutput;
use App\Documentation\Application\UseCase\GetVersionByName\GetVersionByNameQuery;
use App\Documentation\Domain\Repository\PageByNameProviderInterface;
use App\Shared\Domain\Bus\QueryBusInterface;
use App\Shared\Domain\Bus\QueryId;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(bus: 'query.bus')]
final readonly class GetPageByNameUseCase
{
    public function __construct(
        private PageByNameProviderInterface $pages,
        private QueryBusInterface $queries,
    ) {}

    public function __invoke(GetPageByNameQuery $query): GetPageByNameOutput
    {
        $name = $query->name;
        $version = $query->version;

        /** @var GetVersionByNameOutput $result */
        $result = $this->queries->get(new GetVersionByNameQuery(
            version: $version,
            id: QueryId::createFrom($query->id),
        ));

        $page = $this->pages->findByName($result->version->name, $name)
            ?? throw new PageNotFoundException();

        return new GetPageByNameOutput(
            version: VersionOutput::fromVersion($page->version),
            category: CategoryOutput::fromCategory($page->category),
            page: DocumentOutput::fromDocument($page),
        );
    }
}
