<?php

declare(strict_types=1);

namespace App\Blog\Infrastructure\Persistence\Doctrine\Repository;

use App\Blog\Domain\Article;
use App\Blog\Domain\ArticleRepositoryInterface;
use App\Blog\Domain\Category\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\String\UnicodeString;

/**
 * @api
 *
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal App\Blog\Infrastructure\Persistence\Doctrine\Repository
 *
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
        int       $page = self::DEFAULT_PAGE,
        int       $itemsPerPage = self::DEFAULT_ITEMS_PER_PAGE,
        ?Category $category = null,
    ): Paginator {
        $builder = $this->createQueryBuilder('a')
            ->orderBy('a.createdAt', 'DESC')
            ->setFirstResult(($page - 1) * $itemsPerPage)
            ->setMaxResults($itemsPerPage);

        if ($category !== null) {
            $builder->andWhere('a.category = :category')
                ->setParameter('category', $category);
        }

        /** @var Paginator<Article> */
        return new Paginator(
            query: $builder->getQuery(),
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
