<?php

declare(strict_types=1);

namespace App\Sync\Infrastructure\Persistence\Repository;

use App\Sync\Domain\ExternalDocument;
use App\Sync\Domain\ExternalDocumentId;
use App\Sync\Domain\ExternalDocumentRepositoryInterface;
use App\Sync\Domain\Version\ExternalVersion;
use App\Sync\Infrastructure\Persistence\Repository\ExternalDocumentGitHubRepository\LazyInitializedExternalDocumentContent;
use Github\Exception\RuntimeException;

/**
 * @phpstan-type DocumentArrayType array{
 *     name: non-empty-string,
 *     path: non-empty-string,
 *     sha: non-empty-lowercase-string,
 *     size: int<0, max>,
 *     url: non-empty-string,
 *     html_url: non-empty-string,
 *     git_url: non-empty-string,
 *     download_url: non-empty-string,
 *     type: non-empty-string,
 *     content: non-empty-string,
 *     encoding: non-empty-string,
 *     _links: array{
 *         self: non-empty-string,
 *         git: non-empty-string,
 *         html: non-empty-string
 *     }
 * }
 * @phpstan-type DocumentsListArrayType array{
 *     sha: non-empty-string,
 *     url: non-empty-string,
 *     tree: list<array{
 *         path: non-empty-string,
 *         mode: numeric-string,
 *         type: non-empty-string,
 *         sha: non-empty-lowercase-string,
 *         size: int<0, max>,
 *         url: non-empty-string
 *     }>,
 *     truncated: bool
 * }
 *
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal App\Sync\Infrastructure\Persistence\Repository
 */
final readonly class ExternalDocumentGitHubRepository extends GitHubRepository implements
    ExternalDocumentRepositoryInterface
{
    public function getAll(string|ExternalVersion $version): iterable
    {
        if ($version instanceof ExternalVersion) {
            $version = $version->name;
        }

        /** @var DocumentsListArrayType $response */
        $response = $this->github->git()
            ->trees()
            ->show($this->owner, $this->repository, $version, true);

        foreach ($response['tree'] as $item) {
            if ($item['type'] !== 'blob') {
                continue;
            }

            yield new ExternalDocument(
                id: ExternalDocumentId::createFromVersionAndPath($version, $item['path']),
                hash: $item['sha'],
                name: $item['path'],
                content: new LazyInitializedExternalDocumentContent(
                    version: $version,
                    page: $item['path'],
                    provider: $this,
                ),
            );
        }
    }

    public function findByName(ExternalVersion|string $version, string $name): ?ExternalDocument
    {
        if ($version instanceof ExternalVersion) {
            $version = $version->name;
        }

        try {
            /** @var DocumentArrayType $response */
            $response = $this->github->repository()
                ->contents()
                ->show($this->owner, $this->repository, $name, $version);
        } catch (RuntimeException $e) {
            if ($e->getCode() === 404) {
                return null;
            }

            throw $e;
        }

        return new ExternalDocument(
            id: ExternalDocumentId::createFromVersionAndPath($version, $response['path']),
            hash: $response['sha'],
            name: $response['path'],
            content: self::decodeContent($response),
        );
    }

    /**
     * @param DocumentArrayType $response
     */
    private static function decodeContent(array $response): string
    {
        return match ($response['encoding']) {
            'base64' => (string) \base64_decode($response['content'], true),
            default => $response['content'],
        };
    }
}
