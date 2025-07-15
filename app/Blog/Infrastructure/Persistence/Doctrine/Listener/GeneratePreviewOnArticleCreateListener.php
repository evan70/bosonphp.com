<?php

declare(strict_types=1);

namespace App\Blog\Infrastructure\Persistence\Doctrine\Listener;

use App\Blog\Domain\Article;
use App\Blog\Domain\Content\ArticlePreviewGeneratorInterface;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;

#[AsEntityListener(event: Events::prePersist, entity: Article::class)]
final readonly class GeneratePreviewOnArticleCreateListener
{
    public function __construct(
        private ArticlePreviewGeneratorInterface $generator,
    ) {}

    /**
     * @api
     */
    public function prePersist(Article $article): void
    {
        if ($article->preview !== '') {
            return;
        }

        $article->preview = $this->generator->generatePreview($article->content);
    }
}
