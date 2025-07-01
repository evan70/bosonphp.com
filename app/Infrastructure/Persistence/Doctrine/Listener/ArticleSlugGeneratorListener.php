<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Listener;

use App\Domain\Article\Article;
use App\Domain\Article\Service\ArticleSlugGenerator;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;

/**
 * @api
 */
#[AsEntityListener(event: Events::prePersist, method: '__invoke', entity: Article::class)]
#[AsEntityListener(event: Events::preUpdate, method: '__invoke', entity: Article::class)]
final readonly class ArticleSlugGeneratorListener
{
    public function __construct(
        private ArticleSlugGenerator $generator,
    ) {}

    /**
     * @api
     *
     * @throws \ReflectionException
     */
    public function __invoke(Article $article): void
    {
        $slug = $this->generator->generate($article);

        new \ReflectionObject($article)
            ->getProperty('slug')
            ->setValue($article, $slug);
    }
}
