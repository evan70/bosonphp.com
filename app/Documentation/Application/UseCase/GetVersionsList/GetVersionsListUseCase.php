<?php

declare(strict_types=1);

namespace App\Documentation\Application\UseCase\GetVersionsList;

use App\Documentation\Application\Output\Version\VersionsListOutput;
use App\Documentation\Domain\Version\Repository\VersionsListProviderInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

#[AsMessageHandler(bus: 'query.bus')]
final readonly class GetVersionsListUseCase
{
    public function __construct(
        private VersionsListProviderInterface $versionsListProvider,
        private TagAwareCacheInterface $cache,
    ) {}

    private function keyOf(GetVersionsListQuery $query): string
    {
        return \hash('xxh3', GetVersionsListQuery::class);
    }

    public function __invoke(GetVersionsListQuery $query): GetVersionsListOutput
    {
        return $this->cache->get($this->keyOf($query), function (ItemInterface $item): GetVersionsListOutput {
            $item->tag(['doc', 'doc.version', 'doc.category', 'doc.page']);

            return new GetVersionsListOutput(
                versions: VersionsListOutput::fromVersions(
                    versions: $this->versionsListProvider->getAll(),
                ),
            );
        });
    }
}
