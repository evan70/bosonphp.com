<?php

declare(strict_types=1);

namespace App\Documentation\Application\UseCase\GetVersionByName;

use App\Documentation\Application\Output\Version\VersionOutput;
use App\Documentation\Application\UseCase\GetVersionByName\Exception\VersionNotFoundException;
use App\Documentation\Domain\Version\Repository\CurrentVersionProviderInterface;
use App\Documentation\Domain\Version\Repository\VersionByNameProviderInterface;
use App\Documentation\Domain\Version\Version;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

#[AsMessageHandler(bus: 'query.bus')]
final readonly class GetVersionByNameUseCase
{
    public function __construct(
        private CurrentVersionProviderInterface $currentVersion,
        private VersionByNameProviderInterface $versionsByName,
        private TagAwareCacheInterface $cache,
    ) {}

    private function getVersionEntity(?string $version): ?Version
    {
        if ($version === null || $version === '') {
            return $this->currentVersion->findLatest();
        }

        return $this->versionsByName->findVersionByName($version);
    }

    private function keyOf(GetVersionByNameQuery $query): string
    {
        return \hash('xxh3', GetVersionByNameQuery::class . '::' . $query->version);
    }

    /**
     * @throws VersionNotFoundException
     * @throws \Throwable
     */
    public function __invoke(GetVersionByNameQuery $query): GetVersionByNameOutput
    {
        return $this->cache->get($this->keyOf($query), function(ItemInterface $item) use ($query): GetVersionByNameOutput {
            $item->tag(['doc', 'doc.version', 'doc.category', 'doc.page']);

            $version = $this->getVersionEntity($query->version)
                ?? throw new VersionNotFoundException();

            return new GetVersionByNameOutput(
                version: VersionOutput::fromVersion($version),
            );
        });
    }
}
