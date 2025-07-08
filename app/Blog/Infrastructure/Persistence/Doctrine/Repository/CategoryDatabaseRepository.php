<?php

declare(strict_types=1);

namespace App\Blog\Infrastructure\Persistence\Doctrine\Repository;

use App\Blog\Domain\Category\Category;
use App\Blog\Domain\Category\CategoryRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\String\UnicodeString;

/**
 * @api
 *
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal App\Blog\Infrastructure\Persistence\Doctrine\Repository
 *
 * @template-extends ServiceEntityRepository<Category>
 */
final class CategoryDatabaseRepository extends ServiceEntityRepository implements
    CategoryRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    public function findBySlug(string $slug): ?Category
    {
        return $this->findOneBy([
            'slug' => new UnicodeString($slug)
                ->lower()
                ->toString(),
        ]);
    }

    /**
     * @return list<Category>
     */
    public function getAll(): array
    {
        return $this->findBy([], [
            'order' => 'ASC',
            'createdAt' => 'DESC',
        ]);
    }
}
