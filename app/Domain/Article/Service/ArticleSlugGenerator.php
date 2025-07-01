<?php

declare(strict_types=1);

namespace App\Domain\Article\Service;

use App\Domain\Article\Article;
use Symfony\Component\String\Slugger\SluggerInterface;

final readonly class ArticleSlugGenerator
{
    public function __construct(
        private SluggerInterface $slugger,
    ) {}

    public function generate(Article $article): string
    {
        return $this->slugger->slug($article->title)
            ->lower()
            ->trim('-')
            // ->prepend('-')
            // ->prepend(new CodePointString($article->id->toString())
            //     ->slice(32)
            //     ->toString())
            ->toString();
    }
}
