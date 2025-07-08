<?php

declare(strict_types=1);

namespace App\Documentation\Application\UseCase\GetDocumentationVersionByName;

use App\Documentation\Application\UseCase\GetDocumentationVersionByName\Exception\VersionNotFoundException;
use App\Documentation\Domain\Version\Repository\CurrentVersionProviderInterface;
use App\Documentation\Domain\Version\Repository\VersionByNameProviderInterface;
use App\Documentation\Domain\Version\Version;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(bus: 'query.bus', method: 'getVersion')]
final readonly class GetDocumentationVersionByNameUseCase
{
    public const string CURRENT_VERSION_ALIAS = 'current';

    public function __construct(
        private CurrentVersionProviderInterface $currentVersion,
        private VersionByNameProviderInterface $versionsByName,
    ) {}

    private function getVersionEntity(?string $version): ?Version
    {
        $isCurrentVersion = $version === null
            || $version === ''
            || \strtolower($version) === self::CURRENT_VERSION_ALIAS;

        if ($isCurrentVersion) {
            return $this->currentVersion->findLatest();
        }

        return $this->versionsByName->findVersionByName($version);
    }

    /**
     * @throws VersionNotFoundException
     */
    public function getVersion(GetDocumentationVersionByNameQuery $query): GetDocumentationVersionByNameResult
    {
        $instance = $this->getVersionEntity($query->version);

        return new GetDocumentationVersionByNameResult(
            version: $instance ?? throw new VersionNotFoundException(),
        );
    }
}
