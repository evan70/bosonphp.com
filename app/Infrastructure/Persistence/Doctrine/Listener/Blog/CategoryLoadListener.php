<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Listener\Blog;

use App\Domain\Blog\Category\ArticleCategory;
use App\Domain\Blog\Category\ArticleCategorySlugGeneratorInterface;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;

/**
 * @api
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
