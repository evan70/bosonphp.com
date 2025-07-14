<?php

declare(strict_types=1);

namespace App\Documentation\Infrastructure\Persistence\Doctrine\Repository;

use App\Documentation\Domain\PageDocument;
use App\Documentation\Domain\PageRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @api
 *
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal App\Documentation\Infrastructure\Persistence\Doctrine\Repository
 *
 * @template-extends ServiceEntityRepository<PageDocument>
 */
final class PageDatabaseRepository extends ServiceEntityRepository implements
    PageRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PageDocument::class);
    }

    public function findByName(string $version, string $name): ?PageDocument
    {
        $query = $this->createQueryBuilder('page')
            ->join('page.category', 'category')
            ->where('page.uri = :uri')
            ->setParameter('uri', $name)
            ->join('category.version', 'version')
            ->andWhere('version.name = :version')
            ->setParameter('version', $version)
            ->getQuery();

        /** @var PageDocument|null */
        return $query->getOneOrNullResult();
    }
}
