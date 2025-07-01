<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Repository;

use App\Domain\Article\Article;
use App\Domain\Article\ArticleRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\String\UnicodeString;

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

    /**
     * @return Paginator<Article>
     */
    public function getAllAsPaginator(
        int $page = self::DEFAULT_PAGE,
        int $itemsPerPage = self::DEFAULT_ITEMS_PER_PAGE,
    ): Paginator {
        /** @var Paginator<Article> */
        return new Paginator(
            query: $this->createQueryBuilder('a')
                ->orderBy('a.createdAt', 'DESC')
                ->setFirstResult(($page - 1) * $itemsPerPage)
                ->setMaxResults($itemsPerPage)
                ->getQuery(),
            fetchJoinCollection: true,
        );
    }

    public function findBySlug(string $slug): ?Article
    {
        return $this->findOneBy([
            'slug' => new UnicodeString($slug)
                ->lower()
                ->toString(),
        ]);
    }
}
