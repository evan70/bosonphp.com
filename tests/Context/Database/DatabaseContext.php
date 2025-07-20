<?php

declare(strict_types=1);

namespace App\Tests\Context\Database;

use App\Tests\Context\SymfonyContext;
use Behat\Step\Given;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Schema\AbstractSchemaManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadataFactory;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Component\Console\Output\StreamOutput;
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

    public function getSchemaTool(?EntityManagerInterface $em = null): SchemaTool
    {
        return new SchemaTool($em ?? $this->em);
    }

    public function getMetadataFactory(?EntityManagerInterface $em = null): ClassMetadataFactory
    {
        return ($em ?? $this->em)->getMetadataFactory();
    }

    public function getConnection(?EntityManagerInterface $em = null): Connection
    {
        return ($em ?? $this->em)->getConnection();
    }

    /**
     * @return AbstractSchemaManager<AbstractPlatform>
     * @throws Exception
     */
    public function getSchemaManager(?Connection $connection = null): AbstractSchemaManager
    {
        $connection ??= $this->getConnection();

        return $connection->createSchemaManager();
    }

    public function migrationsMigrateLast(): string
    {
        $command = $this->console('doctrine:migrations:migrate');
        $command->execute([], ['interactive' => false]);

        return $this->getConsoleOutput($command);
    }

    public function migrationsMigrateFirst(): string
    {
        $command = $this->console('doctrine:migrations:migrate');
        $command->execute(['version' => 'first'], ['interactive' => false]);

        return $this->getConsoleOutput($command);
    }

    public function databaseDrop(): string
    {
        $command = $this->console('doctrine:database:drop');
        $command->execute(['--silent' => true, '--force' => true], ['interactive' => false]);

        return $this->getConsoleOutput($command);
    }

    public function databaseCreate(): string
    {
        $command = $this->console('doctrine:database:create');
        $command->execute([], ['interactive' => false]);

        return $this->getConsoleOutput($command);
    }

    public function databaseRecreate(): string
    {
        return $this->databaseDrop()
            . "\n"
            . $this->databaseCreate();
    }

    /**
     * @api
     */
    #[Given('empty database')]
    public function givenEmptyDatabase(): void
    {
        $this->databaseRecreate();
        $this->migrationsMigrateLast();
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
