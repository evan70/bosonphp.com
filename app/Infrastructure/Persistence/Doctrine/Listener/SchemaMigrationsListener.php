<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Listener;

use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Schema\AbstractSchemaManager;
use Doctrine\DBAL\Schema\PostgreSQLSchemaManager;
use Doctrine\DBAL\Schema\SchemaException;
use Doctrine\ORM\Tools\Event\GenerateSchemaEventArgs;
use Doctrine\ORM\Tools\ToolEvents;

/**
 * @api
 */
#[AsDoctrineListener(event: ToolEvents::postGenerateSchema)]
final readonly class SchemaMigrationsListener
{
    /**
     * @throws Exception
     * @throws SchemaException
     */
    public function postGenerateSchema(GenerateSchemaEventArgs $event): void
    {
        $schemaManager = $this->getSchemaManager($event);

        if (!$schemaManager instanceof PostgreSQLSchemaManager) {
            return;
        }

        $schema = $event->getSchema();

        foreach ($schemaManager->listSchemaNames() as $namespace) {
            if (!$schema->hasNamespace($namespace)) {
                $schema->createNamespace($namespace);
            }
        }
    }

    /**
     * @throws Exception
     */
    private function getSchemaManager(GenerateSchemaEventArgs $event): AbstractSchemaManager
    {
        return $event
            ->getEntityManager()
            ->getConnection()
            ->createSchemaManager();
    }
}
