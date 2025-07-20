<?php

declare(strict_types=1);

namespace App\Tests\Context\Database;

use App\Tests\Context\SymfonyContext;
use Behat\Step\Given;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * @api
 * @see http://behat.org/en/latest/quick_start.html
 */
final class DatabaseContext extends SymfonyContext
{
    public function __construct(
        KernelInterface $kernel,
        private readonly EntityManagerInterface $em,
    ) {
        parent::__construct($kernel);
    }

    public function migrateUp(): void
    {
        $this->console('doctrine:migrations:migrate')
            ->execute(['--no-interaction']);
    }

    public function migrateDown(): void
    {
        $this->console('doctrine:migrations:migrate')
            ->execute(['first', '--no-interaction']);
    }

    /**
     * @api
     */
    #[Given('empty database')]
    public function givenEmptyDatabase(): void
    {
        $this->migrateDown();
        $this->migrateUp();
    }

    /**
     * @template TObject of object
     *
     * @param TObject $entity
     *
     * @return TObject
     */
    public function given(object $entity, ?EntityManagerInterface $em = null): object
    {
        $em ??= $this->em;

        $em->persist($entity);
        $em->flush();
        $em->clear();

        return $entity;
    }
}
