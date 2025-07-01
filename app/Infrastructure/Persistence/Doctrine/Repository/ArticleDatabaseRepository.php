<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Repository;

use App\Domain\Article\Article;
use App\Domain\Article\ArticleRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @template-extends ServiceEntityRepository<Article>
 */
final class ArticleDatabaseRepository extends ServiceEntityRepository implements
    ArticleRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function getAllAsPaginator(int $page = 1): iterable
    {
        $query = $this->createQueryBuilder('a')
            ->orderBy('a.createdAt', 'DESC')
            ->setFirstResult(($page - 1) * 10)
            ->setMaxResults(10)
            ->getQuery();

        return new Paginator($query, true);
    }
}
