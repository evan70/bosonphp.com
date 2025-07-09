<?php

declare(strict_types=1);

namespace App\Documentation\Infrastructure\Persistence\Doctrine\Repository;

use App\Documentation\Domain\Category\Category;
use App\Documentation\Domain\Version\Status;
use App\Documentation\Domain\Version\Version;
use App\Documentation\Domain\Version\VersionRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\FetchMode;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @api
 *
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal App\Documentation\Infrastructure\Persistence\Doctrine\Repository
 *
 * @template-extends ServiceEntityRepository<Version>
 */
final class VersionDatabaseRepository extends ServiceEntityRepository implements
    VersionRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Version::class);
    }

    public function findLatest(): ?Version
    {
        $query = $this->createQueryBuilder('ver')
            ->where('ver.status = :status')
            ->setParameter('status', Status::DEFAULT)
            ->orderBy('ver.name', 'DESC')
            ->setMaxResults(1)
            ->getQuery();

        /** @var Version|null */
        return $query->getOneOrNullResult();
    }

    public function findVersionByName(string $name): ?Version
    {
        $query = $this->createQueryBuilder('ver')
            ->where('ver.name = :name')
            ->setParameter('name', $name)
            ->setMaxResults(1)
            ->getQuery();

        /** @var Version|null */
        return $query->getOneOrNullResult();
    }

    public function getAll(): iterable
    {
        $query = $this->createQueryBuilder('ver')
            ->where('ver.status <> :status')
            ->setParameter('status', Status::Hidden)
            ->orderBy('ver.name', 'DESC')
            ->getQuery();

        $query->setFetchMode(Version::class, 'categories', ClassMetadata::FETCH_LAZY);

        /** @var iterable<array-key, Version> */
        return $query->getResult();
    }
}
