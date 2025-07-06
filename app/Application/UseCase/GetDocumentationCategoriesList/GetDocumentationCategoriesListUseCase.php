<?php

declare(strict_types=1);

namespace App\Application\UseCase\GetDocumentationCategoriesList;

use App\Application\UseCase\GetDocumentationCategoriesList\Exception\VersionNotFoundException;
use App\Domain\Documentation\Version\Repository\CurrentVersionProviderInterface;
use App\Domain\Documentation\Version\Repository\VersionByNameProviderInterface;
use App\Domain\Documentation\Version\Version;

final readonly class GetDocumentationCategoriesListUseCase
{
    public const string CURRENT_VERSION_ALIAS = 'current';

    public function __construct(
        private CurrentVersionProviderInterface $currentVersion,
        private VersionByNameProviderInterface $versionsByName,
    ) {}

    /**
     * @throws VersionNotFoundException
     */
    private function getVersion(?string $version): Version
    {
        $instance = match (\strtolower($version ?? '')) {
            self::CURRENT_VERSION_ALIAS, '' => $this->currentVersion->findLatest(),
            default => $this->versionsByName->findVersionByName($version),
        };

        return $instance
            ?? throw new VersionNotFoundException();
    }

    public function getCategories(?string $version): GetDocumentationCategoriesListResult
    {
        $version = $this->getVersion($version);

        return new GetDocumentationCategoriesListResult(
            version: $version,
            categories: $version->categories,
        );
    }
}
