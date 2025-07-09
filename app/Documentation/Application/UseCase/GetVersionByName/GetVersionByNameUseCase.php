<?php

declare(strict_types=1);

namespace App\Documentation\Application\UseCase\GetVersionByName;

use App\Documentation\Application\Output\Version\VersionOutput;
use App\Documentation\Application\UseCase\GetVersionByName\Exception\VersionNotFoundException;
use App\Documentation\Domain\Version\Repository\CurrentVersionProviderInterface;
use App\Documentation\Domain\Version\Repository\VersionByNameProviderInterface;
use App\Documentation\Domain\Version\Version;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(bus: 'query.bus')]
final readonly class GetVersionByNameUseCase
{
    public function __construct(
        private CurrentVersionProviderInterface $currentVersion,
        private VersionByNameProviderInterface $versionsByName,
    ) {}

    private function getVersionEntity(?string $version): ?Version
    {
        if ($version === null || $version === '') {
            return $this->currentVersion->findLatest();
        }

        return $this->versionsByName->findVersionByName($version);
    }

    /**
     * @throws VersionNotFoundException
     */
    public function __invoke(GetVersionByNameQuery $query): GetVersionByNameOutput
    {
        $version = $this->getVersionEntity($query->version)
            ?? throw new VersionNotFoundException();

        return new GetVersionByNameOutput(
            version: VersionOutput::fromVersion($version),
        );
    }
}
