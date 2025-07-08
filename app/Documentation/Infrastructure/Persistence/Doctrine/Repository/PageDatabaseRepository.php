<?php

declare(strict_types=1);

namespace App\Documentation\Infrastructure\Persistence\Doctrine\Repository;

use App\Documentation\Domain\PageDocument;
use App\Documentation\Domain\PageRepositoryInterface;
use App\Documentation\Domain\Version\Version;
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

    public function findByName(Version $version, string $name): ?PageDocument
    {
        $query = $this->createQueryBuilder('page')
            ->join('page.category', 'category')
            ->where('page.uri = :uri')
            ->andWhere('category.version = :version')
            ->setParameter('version', $version)
            ->setParameter('uri', $name)
            ->getQuery();

        /** @var PageDocument|null */
        return $query->getOneOrNullResult();
    }
}
