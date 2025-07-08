<?php

declare(strict_types=1);

namespace App\Blog\Infrastructure\Persistence\Doctrine\Listener;

use App\Blog\Domain\Category\ArticleCategory;
use App\Blog\Domain\Category\ArticleCategorySlugGeneratorInterface;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;

/**
 * @api
 *
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal App\Blog\Infrastructure\Persistence\Doctrine\Listener
 */
#[AsEntityListener(event: Events::postLoad, entity: ArticleCategory::class)]
final readonly class CategoryLoadListener
{
    public function __construct(
        private ArticleCategorySlugGeneratorInterface $slugGenerator,
    ) {}

    /**
     * @api
     *
     * @throws \ReflectionException
     */
    public function postLoad(ArticleCategory $category): void
    {
        $this->bootSlugGenerator($category);
    }

    /**
     * @throws \ReflectionException
     */
    private function bootSlugGenerator(ArticleCategory $category): void
    {
        $slugGenerator = new \ReflectionProperty($category, 'slugGenerator');

        if ($slugGenerator->isInitialized($category)) {
            return;
        }

        $slugGenerator->setValue($category, $this->slugGenerator);
    }
}
