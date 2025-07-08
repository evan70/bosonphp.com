<?php

declare(strict_types=1);

namespace App\Documentation\Infrastructure\Persistence\Doctrine\Repository;

use App\Documentation\Domain\Version\Status;
use App\Documentation\Domain\Version\Version;
use App\Documentation\Domain\Version\VersionRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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
        return $this->findOneBy(
            criteria: ['status' => Status::DEFAULT],
            orderBy: ['name' => 'DESC']
        );
    }

    public function findVersionByName(string $name): ?Version
    {
        return $this->findOneBy(['name' => $name]);
    }

    public function getAll(): iterable
    {
        $query = $this->createQueryBuilder('ver')
            ->where('ver.status <> :status')
            ->setParameter('status', Status::Hidden)
            ->orderBy('ver.name', 'DESC')
            ->getQuery();

        /** @var list<Version> */
        return $query->getArrayResult();
    }
}
