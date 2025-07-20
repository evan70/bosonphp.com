<?php

declare(strict_types=1);

namespace App\Blog\Infrastructure\Persistence\Doctrine\Listener;

use App\Blog\Domain\Article;
use App\Blog\Domain\Content\ArticleContentRendererInterface;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;

#[AsEntityListener(event: Events::preUpdate, entity: Article::class, priority: 256)]
#[AsEntityListener(event: Events::prePersist, entity: Article::class, priority: 256)]
final readonly class RenderContentOnArticleSaveListener
{
    public function __construct(
        private ArticleContentRendererInterface $renderer,
    ) {}

    /**
     * @api
     */
    public function prePersist(Article $article): void
    {
        $article->content->render($this->renderer);
    }

    /**
     * @api
     */
    public function preUpdate(Article $article, PreUpdateEventArgs $event): void
    {
        if (!$event->hasChangedField('content.value')) {
            return;
        }

        $article->content->render($this->renderer);
    }
}
