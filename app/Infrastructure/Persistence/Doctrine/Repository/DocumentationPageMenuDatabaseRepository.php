<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Repository;

use App\Domain\Documentation\Menu\PageMenu;
use App\Domain\Documentation\Menu\PageMenuRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @template-extends ServiceEntityRepository<PageMenu>
 */
final class DocumentationPageMenuDatabaseRepository extends ServiceEntityRepository implements
    PageMenuRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PageMenu::class);
    }

    /**
     * @return list<PageMenu>
     */
    public function getAll(): array
    {
        return $this->findBy([], [
            'order' => 'ASC',
            'createdAt' => 'DESC',
        ]);
    }
}
