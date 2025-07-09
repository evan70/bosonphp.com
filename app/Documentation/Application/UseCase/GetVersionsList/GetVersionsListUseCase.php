<?php

declare(strict_types=1);

namespace App\Documentation\Application\UseCase\GetVersionsList;

use App\Documentation\Application\Output\Version\VersionsListOutput;
use App\Documentation\Domain\Version\Repository\VersionsListProviderInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(bus: 'query.bus')]
final readonly class GetVersionsListUseCase
{
    public function __construct(
        private VersionsListProviderInterface $versionsListProvider,
    ) {}

    public function __invoke(GetVersionsListQuery $query): GetVersionsListOutput
    {
        return new GetVersionsListOutput(
            versions: VersionsListOutput::fromVersions(
                versions: $this->versionsListProvider->getAll(),
            ),
        );
    }
}
