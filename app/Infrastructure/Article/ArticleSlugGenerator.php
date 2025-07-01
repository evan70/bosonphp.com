<?php

declare(strict_types=1);

namespace App\Infrastructure\Article;

use App\Domain\Article\ArticleSlugGeneratorInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

final readonly class ArticleSlugGenerator implements ArticleSlugGeneratorInterface
{
    public function __construct(
        private SluggerInterface $slugger,
    ) {}

    public function createSlug(object $entity): string
    {
        return $this->slugger->slug($entity->title)
            ->lower()
            ->trim('-')
            ->toString();
    }
}
