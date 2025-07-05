<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Repository;

use App\Domain\Documentation\Category\Category;
use App\Domain\Documentation\Category\CategoryRepositoryInterface;
use App\Domain\Documentation\Version\Version;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @template-extends ServiceEntityRepository<Category>
 */
final class DocumentationCategoryDatabaseRepository extends ServiceEntityRepository implements
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
