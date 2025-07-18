<?php

declare(strict_types=1);

namespace App\Documentation\Infrastructure\Persistence\Doctrine\Repository;

use App\Documentation\Domain\Version\Status;
use App\Documentation\Domain\Version\Version;
use App\Documentation\Domain\Version\VersionRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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
            ->addSelect("(
                CASE ver.status
                    WHEN 'stable' THEN 0
                    WHEN 'dev' THEN 1
                    WHEN 'deprecated' THEN 2
                    ELSE 3
                END
            ) AS HIDDEN ordered_status")
            ->addOrderBy('ordered_status', 'ASC')
            ->addOrderBy('ver.name', 'DESC')
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

    public function getAll(bool $hidden = false): iterable
    {
        $builder = $this->createQueryBuilder('ver')
            ->orderBy('ver.name', 'DESC');

        if ($hidden === false) {
            $builder = $builder->where('ver.status <> :status')
                ->setParameter('status', Status::Hidden);
        }

        $query = $builder->getQuery();
        $query->setFetchMode(Version::class, 'categories', ClassMetadata::FETCH_LAZY);

        /** @var iterable<array-key, Version> */
        return $query->getResult();
    }
}
