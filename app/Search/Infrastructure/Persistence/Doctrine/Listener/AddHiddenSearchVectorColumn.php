<?php

declare(strict_types=1);

namespace App\Search\Infrastructure\Persistence\Doctrine\Listener;

use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\DBAL\Event\SchemaColumnDefinitionEventArgs;
use Doctrine\DBAL\Event\SchemaIndexDefinitionEventArgs;
use Doctrine\DBAL\Events;

/**
 * Referenced to migration {@see Version20250714000328}
 */
#[AsDoctrineListener(Events::onSchemaColumnDefinition)]
#[AsDoctrineListener(Events::onSchemaIndexDefinition)]
final readonly class AddHiddenSearchVectorColumn
{
    /**
     * Skip generation and removement doc_pages.search_vector column
     *
     * @api
     */
    public function onSchemaColumnDefinition(SchemaColumnDefinitionEventArgs $event): void
    {
        if ($event->getTable() !== 'doc_pages') {
            return;
        }

        if (($event->getTableColumn()['field'] ?? null) !== 'search_vector') {
            return;
        }

        $event->preventDefault();
    }

    /**
     * Skip generation and removement doc_pages.doc_pages_search_idx index
     *
     * @api
     */
    public function onSchemaIndexDefinition(SchemaIndexDefinitionEventArgs $event): void
    {
        if ($event->getTable() !== 'doc_pages') {
            return;
        }

        if (($event->getTableIndex()['name'] ?? null) !== 'doc_pages_search_idx') {
            return;
        }

        $event->preventDefault();
    }
}
