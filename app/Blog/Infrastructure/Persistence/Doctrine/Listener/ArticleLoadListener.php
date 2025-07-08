<?php

declare(strict_types=1);

namespace App\Blog\Infrastructure\Persistence\Doctrine\Listener;

use App\Blog\Domain\Article;
use App\Blog\Domain\ArticleContent;
use App\Blog\Domain\ArticleContentRendererInterface;
use App\Blog\Domain\ArticleSlugGeneratorInterface;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;

/**
 * @api
 *
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal App\Blog\Infrastructure\Persistence\Doctrine\Listener
 */
#[AsEntityListener(event: Events::postLoad, entity: Article::class)]
final readonly class ArticleLoadListener
{
    public function __construct(
        private ArticleContentRendererInterface $contentRenderer,
        private ArticleSlugGeneratorInterface $slugGenerator,
    ) {}

    /**
     * @api
     *
     * @throws \ReflectionException
     */
    public function postLoad(Article $article): void
    {
        $this->bootSlugGenerator($article);
        $this->bootContentRenderer($article->content);
    }

    /**
     * @throws \ReflectionException
     */
    private function bootContentRenderer(ArticleContent $content): void
    {
        $contentRenderer = new \ReflectionProperty($content, 'contentRenderer');

        if ($contentRenderer->isInitialized($content)) {
            return;
        }

        $contentRenderer->setValue($content, $this->contentRenderer);
    }

    /**
     * @throws \ReflectionException
     */
    private function bootSlugGenerator(Article $article): void
    {
        $slugGenerator = new \ReflectionProperty($article, 'slugGenerator');

        if ($slugGenerator->isInitialized($article)) {
            return;
        }

        $slugGenerator->setValue($article, $this->slugGenerator);
    }
}
