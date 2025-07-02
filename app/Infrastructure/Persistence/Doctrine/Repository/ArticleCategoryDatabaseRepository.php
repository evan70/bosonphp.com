<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Repository;

use App\Domain\Blog\Category\ArticleCategory;
use App\Domain\Blog\Category\ArticleCategoryRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @template-extends ServiceEntityRepository<ArticleCategory>
 */
final class ArticleCategoryDatabaseRepository extends ServiceEntityRepository implements
    ArticleCategoryRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ArticleCategory::class);
    }

    public function getAll(): iterable
    {
        return $this->findBy([], [
            'order' => 'ASC',
        ]);
    }
}
