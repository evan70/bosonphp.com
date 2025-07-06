<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Repository;

use App\Domain\Documentation\Version\Status;
use App\Domain\Documentation\Version\Version;
use App\Domain\Documentation\Version\VersionRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @template-extends ServiceEntityRepository<Version>
 */
final class DocumentationVersionDatabaseRepository extends ServiceEntityRepository implements
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
