<?php

declare(strict_types=1);

namespace App\Sync\Infrastructure\Persistence\Repository;

use App\Sync\Domain\Category\Repository\ExternalCategoriesListProviderInterface;
use App\Sync\Domain\Version\ExternalVersion;
use App\Sync\Domain\Version\ExternalVersionRepositoryInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\ReadableCollection;
use Github\Client as GitHubClient;

/**
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal App\Sync\Infrastructure\Persistence\Repository
 */
final readonly class ExternalVersionGitHubRepository extends GitHubRepository implements
    ExternalVersionRepositoryInterface
{
    /**
     * @param non-empty-string $owner
     * @param non-empty-string $repository
     */
    public function __construct(
        string $owner,
        string $repository,
        GitHubClient $github,
        private ExternalCategoriesListProviderInterface $externalCategoriesListProvider,
    ) {
        parent::__construct($owner, $repository, $github);
    }

    public function getAll(): iterable
    {
        /**
         * @var list<array{
         *     name: non-empty-string,
         *     commit: array{
         *         sha: non-empty-lowercase-string,
         *         url: non-empty-string,
         *         ...
         *     },
         *     protected: bool
         * }> $result
         */
        $result = $this->github->repository()
            ->branches($this->owner, $this->repository);

        $reflection = new \ReflectionClass(ExternalVersion::class);

        foreach ($result as $item) {
            $hash = $item['commit']['sha'];
            $name = $item['name'];

            $instance = $reflection->newInstanceWithoutConstructor();

            $reflection->getProperty('hash')
                ->setRawValue($instance, $hash);

            $reflection->getProperty('name')
                ->setRawValue($instance, $name);

            $reflection->getProperty('categories')
                ->setRawValue($instance, new \ReflectionClass(ArrayCollection::class)
                    ->newLazyProxy(function () use ($name): ReadableCollection {
                        return new ArrayCollection(\iterator_to_array(
                            iterator: $this->externalCategoriesListProvider->getAll($name),
                            preserve_keys: false,
                        ));
                    }));

            yield $instance;
        }
    }
}
