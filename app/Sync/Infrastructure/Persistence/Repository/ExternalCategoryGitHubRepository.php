<?php

declare(strict_types=1);

namespace App\Sync\Infrastructure\Persistence\Repository;

use App\Sync\Domain\Category\ExternalCategory;
use App\Sync\Domain\Category\ExternalCategoryId;
use App\Sync\Domain\Category\ExternalCategoryRepositoryInterface;
use App\Sync\Domain\ExternalDocument;
use App\Sync\Domain\Repository\ExternalDocumentByNameProviderInterface;
use App\Sync\Domain\Repository\ExternalDocumentReferencesListProviderInterface;
use App\Sync\Domain\Version\ExternalVersion;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\ReadableCollection;

/**
 * @phpstan-type NavigationArrayType list<array{
 *     title: non-empty-string,
 *     description?: non-empty-string,
 *     icon?: non-empty-string,
 *     hidden?: bool,
 *     pages?: list<non-empty-string>
 * }>
 *
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal App\Sync\Infrastructure\Persistence\Repository
 */
final readonly class ExternalCategoryGitHubRepository implements
    ExternalCategoryRepositoryInterface
{
    public function __construct(
        /**
         * @var non-empty-string
         */
        private string $navigation,
        private ExternalDocumentByNameProviderInterface $docByNameProvider,
        private ExternalDocumentReferencesListProviderInterface $docsListProvider,
    ) {}

    /**
     * @return NavigationArrayType|null
     */
    private function parseNavigation(ExternalDocument $document): ?array
    {
        try {
            $result = \json_decode((string) $document->content, true, flags: \JSON_THROW_ON_ERROR);
        } catch (\JsonException) {
            return null;
        }

        if (!\is_array($result)) {
            return null;
        }

        /** @var NavigationArrayType */
        return $result;
    }

    public function getAll(ExternalVersion|string $version): iterable
    {
        if ($version instanceof ExternalVersion) {
            $version = $version->name;
        }

        $page = $this->docByNameProvider->findByName($version, $this->navigation);

        if ($page === null) {
            return [];
        }

        $navigation = $this->parseNavigation($page);

        if ($navigation === null) {
            return [];
        }

        $reflection = new \ReflectionClass(ExternalCategory::class);
        $references = $this->getAvailableExternalDocuments($version);

        foreach ($navigation as $category) {
            if ($category['hidden'] ?? false) {
                continue;
            }

            $instance = $reflection->newInstanceWithoutConstructor();

            $reflection->getProperty('id')
                ->setRawValue($instance, ExternalCategoryId::createFromVersionAndName(
                    version: $version,
                    name: $category['title'],
                ));

            $reflection->getProperty('hash')
                ->setRawValue($instance, $page->hash);

            $reflection->getProperty('name')
                ->setRawValue($instance, $category['title']);

            $reflection->getProperty('description')
                ->setRawValue($instance, $category['description'] ?? null);

            $reflection->getProperty('icon')
                ->setRawValue($instance, $category['icon'] ?? null);

            $reflection->getProperty('pages')
                ->setRawValue($instance, new \ReflectionClass(ArrayCollection::class)
                    ->newLazyProxy(function () use ($references, $category): ReadableCollection {
                        $pages = [];

                        foreach ($category['pages'] ?? [] as $document) {
                            $found = $references->findFirst(static fn(int|string $key, ExternalDocument $doc): bool
                                => $doc->name === $document);

                            if ($found !== null) {
                                $pages[] = $found;
                            }
                        }

                        return new ArrayCollection($pages);
                    }));

            yield $instance;
        }
    }

    /**
     * @param non-empty-string $version
     *
     * @return ReadableCollection<array-key, ExternalDocument>
     */
    private function getAvailableExternalDocuments(string $version): ReadableCollection
    {
        return new \ReflectionClass(ArrayCollection::class)
            ->newLazyProxy(function () use ($version): ReadableCollection {
                return new ArrayCollection(\iterator_to_array(
                    iterator: $this->docsListProvider->getAll($version),
                    preserve_keys: false,
                ));
            });
    }
}
