<?php

declare(strict_types=1);

namespace App\Documentation\Infrastructure\Persistence\Doctrine\Repository;

use App\Documentation\Domain\Category\Category;
use App\Documentation\Domain\Category\CategoryRepositoryInterface;
use App\Documentation\Domain\Version\Version;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @api
 *
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal App\Documentation\Infrastructure\Persistence\Doctrine\Repository
 *
 * @template-extends ServiceEntityRepository<Category>
 */
final class CategoryDatabaseRepository extends ServiceEntityRepository implements
    CategoryRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    /**
     * @return list<Category>
     */
    public function getAll(Version $version): array
    {
        return $this->findBy([
            'version' => $version,
        ], [
            'order' => 'ASC',
            'createdAt' => 'DESC',
        ]);
    }
}
