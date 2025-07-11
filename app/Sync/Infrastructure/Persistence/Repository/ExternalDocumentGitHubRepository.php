<?php

declare(strict_types=1);

namespace App\Sync\Infrastructure\Persistence\Repository;

use App\Sync\Domain\ExternalDocumentReference;
use App\Sync\Domain\ExternalDocumentRepositoryInterface;
use App\Sync\Domain\ExternalDocument;
use App\Sync\Domain\Version\ExternalVersion;
use Github\Exception\RuntimeException;

final class ExternalDocumentGitHubRepository extends GitHubRepository implements
    ExternalDocumentRepositoryInterface
{
    public function getAllReferences(string|ExternalVersion $version): iterable
    {
        if ($version instanceof ExternalVersion) {
            $version = $version->name;
        }

        /**
         * @var array{
         *     sha: non-empty-string,
         *     url: non-empty-string,
         *     tree: list<array{
         *         path: non-empty-string,
         *         mode: numeric-string,
         *         type: non-empty-string,
         *         sha: non-empty-string,
         *         size: int<0, max>,
         *         url: non-empty-string
         *     }>,
         *     truncated: bool
         * } $response
         */
        $response = $this->github->git()
            ->trees()
            ->show($this->owner, $this->repository, $version, true);

        foreach ($response['tree'] as $item) {
            if ($item['type'] !== 'blob') {
                continue;
            }

            yield new ExternalDocumentReference(
                path: $item['path'],
                hash: $item['sha'],
            );
        }
    }

    public function findByName(ExternalVersion|string $version, string $name): ?ExternalDocument
    {
        if ($version instanceof ExternalVersion) {
            $version = $version->name;
        }

        try {
            /**
             * @var array{
             *     name: non-empty-string,
             *     path: non-empty-string,
             *     sha: non-empty-string,
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
             * } $response
             */
            $response = $this->github->repository()
                ->contents()
                ->show($this->owner, $this->repository, $name, $version);
        } catch (RuntimeException $e) {
            if ($e->getCode() === 404) {
                return null;
            }

            throw $e;
        }

        return new \ReflectionClass(ExternalDocument::class)
            ->newLazyProxy(function () use ($response): ExternalDocument {
                return new ExternalDocument(
                    path: $response['path'],
                    hash: $response['sha'],
                    content: match ($response['encoding']) {
                        'base64' => (string) \base64_decode($response['content'], true),
                        default => $response['content'],
                    },
                );
            });
    }
}
