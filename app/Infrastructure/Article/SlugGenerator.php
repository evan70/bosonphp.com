<?php

declare(strict_types=1);

namespace App\Infrastructure\Article;

use App\Domain\Shared\Title\SlugGeneratorInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @template T of object
 * @template-implements SlugGeneratorInterface<T>
 */
abstract readonly class SlugGenerator implements SlugGeneratorInterface
{
    public function __construct(
        private SluggerInterface $slugger,
    ) {}

    /**
     * @param non-empty-string $title
     *
     * @return non-empty-lowercase-string
     */
    protected function createSlugByString(string $title): string
    {
        /** @var non-empty-lowercase-string */
        return $this->slugger->slug($title)
            ->lower()
            ->trim('-')
            ->toString();
    }
}
