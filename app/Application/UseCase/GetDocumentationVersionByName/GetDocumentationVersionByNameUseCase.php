<?php

declare(strict_types=1);

namespace App\Application\UseCase\GetDocumentationVersionByName;

use App\Application\UseCase\GetDocumentationVersionByName\Exception\VersionNotFoundException;
use App\Domain\Documentation\Version\Repository\CurrentVersionProviderInterface;
use App\Domain\Documentation\Version\Repository\VersionByNameProviderInterface;

final readonly class GetDocumentationVersionByNameUseCase
{
    public const string CURRENT_VERSION_ALIAS = 'current';

    public function __construct(
        private CurrentVersionProviderInterface $currentVersion,
        private VersionByNameProviderInterface $versionsByName,
    ) {}

    /**
     * @throws VersionNotFoundException
     */
    public function getVersion(?string $version): GetDocumentationVersionByNameResult
    {
        $instance = match (\strtolower($version ?? '')) {
            self::CURRENT_VERSION_ALIAS, '' => $this->currentVersion->findLatest(),
            default => $this->versionsByName->findVersionByName($version),
        };

        return new GetDocumentationVersionByNameResult(
            version: $instance ?? throw new VersionNotFoundException(),
        );
    }
}
