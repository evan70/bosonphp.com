<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Repository\Blog;

use App\Domain\Blog\Category\ArticleCategory;
use App\Domain\Blog\Category\ArticleCategoryRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\String\UnicodeString;

/**
 * @template-extends ServiceEntityRepository<ArticleCategory>
 */
final class CategoryDatabaseRepository extends ServiceEntityRepository implements
    ArticleCategoryRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ArticleCategory::class);
    }

    public function findBySlug(string $slug): ?ArticleCategory
    {
        return $this->findOneBy([
            'slug' => new UnicodeString($slug)
                ->lower()
                ->toString(),
        ]);
    }

    /**
     * @return list<ArticleCategory>
     */
    public function getAll(): array
    {
        return $this->findBy([], [
            'order' => 'ASC',
            'createdAt' => 'DESC',
        ]);
    }
}
