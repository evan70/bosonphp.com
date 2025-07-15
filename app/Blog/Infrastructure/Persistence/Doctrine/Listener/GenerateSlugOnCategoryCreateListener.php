<?php

declare(strict_types=1);

namespace App\Blog\Infrastructure\Persistence\Doctrine\Listener;

use App\Blog\Domain\Category\Category;
use App\Blog\Domain\Category\CategorySlugGeneratorInterface;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;

#[AsEntityListener(event: Events::prePersist, entity: Category::class)]
final readonly class GenerateSlugOnCategoryCreateListener
{
    public function __construct(
        private CategorySlugGeneratorInterface $generator,
    ) {}

    /**
     * @api
     */
    public function prePersist(Category $category): void
    {
        $category->updateUri($this->generator);
    }
}
