<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Repository;

use App\Domain\Documentation\Page;
use App\Domain\Documentation\PageRepositoryInterface;
use App\Domain\Documentation\Version\Version;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @template-extends ServiceEntityRepository<Page>
 */
final class DocumentationPageDatabaseRepository extends ServiceEntityRepository implements
    PageRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Page::class);
    }

    public function findByName(Version $version, string $name): ?Page
    {
        $query = $this->createQueryBuilder('page')
            ->join('page.category', 'category')
            ->where('page.uri = :uri')
            ->andWhere('category.version = :version')
            ->setParameter('version', $version)
            ->setParameter('uri', $name)
            ->getQuery();

        /** @var Page|null */
        return $query->getOneOrNullResult();
    }
}
