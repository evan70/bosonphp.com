<?php

declare(strict_types=1);

namespace App\Blog\Infrastructure\Persistence\Doctrine\Listener;

use App\Blog\Domain\Article;
use App\Blog\Domain\ArticleSlugGeneratorInterface;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;

#[AsEntityListener(event: Events::prePersist, entity: Article::class)]
final readonly class GenerateSlugOnArticleCreateListener
{
    public function __construct(
        private ArticleSlugGeneratorInterface $generator,
    ) {}

    /**
     * @api
     */
    public function prePersist(Article $article): void
    {
        $article->updateUri($this->generator);
    }
}
