<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Listener;

use App\Domain\Article\Category\Category;
use App\Domain\Article\Category\CategorySlugGeneratorInterface;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;

/**
 * @api
 */
#[AsEntityListener(event: Events::postLoad, entity: Category::class)]
final readonly class ArticleCategoryLoadListener
{
    public function __construct(
        private CategorySlugGeneratorInterface $slugGenerator,
    ) {}

    /**
     * @api
     *
     * @throws \ReflectionException
     */
    public function postLoad(Category $category): void
    {
        $this->bootSlugGenerator($category);
    }

    /**
     * @throws \ReflectionException
     */
    private function bootSlugGenerator(Category $category): void
    {
        $slugGenerator = new \ReflectionProperty($category, 'slugGenerator');

        if ($slugGenerator->isInitialized($category)) {
            return;
        }

        $slugGenerator->setValue($category, $this->slugGenerator);
    }
}
