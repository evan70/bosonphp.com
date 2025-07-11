<?php

declare(strict_types=1);

namespace App\Sync\Infrastructure\Persistence\Repository\ExternalDocumentGitHubRepository;

use App\Sync\Domain\Repository\ExternalDocumentByNameProviderInterface;

/**
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal App\Sync\Infrastructure\Persistence\Repository
 */
final readonly class LazyInitializedExternalDocumentContent implements \Stringable
{
    public function __construct(
        /**
         * @var non-empty-string
         */
        private string $version,
        /**
         * @var non-empty-string
         */
        private string $page,
        private ExternalDocumentByNameProviderInterface $provider,
    ) {}

    public function __toString(): string
    {
        return (string) $this->provider
            ->findByName($this->version, $this->page)
            ?->content;
    }
}
