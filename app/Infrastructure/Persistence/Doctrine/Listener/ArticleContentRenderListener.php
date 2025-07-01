<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Listener;

use App\Domain\Article\Article;
use App\Domain\Article\Content\RendererInterface;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;

/**
 * @api
 */
#[AsEntityListener(event: Events::postLoad, entity: Article::class)]
final readonly class ArticleContentRenderListener
{
    public function __construct(
        private RendererInterface $renderer,
    ) {}

    /**
     * @api
     */
    public function postLoad(Article $article): void
    {
        $content = $article->content;
        $property = new \ReflectionProperty($content, 'renderer');

        if (!$property->isInitialized($content)) {
            $property->setValue($content, $this->renderer);
        }
}
}
