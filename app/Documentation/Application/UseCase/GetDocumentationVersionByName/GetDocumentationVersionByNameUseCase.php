<?php

declare(strict_types=1);

namespace App\Documentation\Application\UseCase\GetDocumentationVersionByName;

use App\Documentation\Application\UseCase\GetDocumentationVersionByName\Exception\VersionNotFoundException;
use App\Documentation\Application\UseCase\GetDocumentationVersionByName\GetDocumentationVersionByNameResult;
use App\Documentation\Domain\Version\Repository\CurrentVersionProviderInterface;
use App\Documentation\Domain\Version\Repository\VersionByNameProviderInterface;

final readonly class GetDocumentationVersionByNameUseCase
{
    public const string CURRENT_VERSION_ALIAS = 'current';

    public function __construct(
        private CurrentVersionProviderInterface $currentVersion,
        private VersionByNameProviderInterface $versionsByName,
    ) {}

    /**
     * @return ($version is non-empty-string ? bool : false)
     */
    private function requiresCurrentVersion(?string $version): bool
    {
        return $version === null
            || $version === ''
            || \strtolower($version) === self::CURRENT_VERSION_ALIAS;
    }

    /**
     * @throws VersionNotFoundException
     */
    public function getVersion(?string $version): GetDocumentationVersionByNameResult
    {
        $instance = $this->requiresCurrentVersion($version)
            ? $this->currentVersion->findLatest()
            /** @phpstan-ignore-next-line : PHPStan false-positive */
            : $this->versionsByName->findVersionByName($version);

        return new GetDocumentationVersionByNameResult(
            version: $instance ?? throw new VersionNotFoundException(),
        );
    }
}
