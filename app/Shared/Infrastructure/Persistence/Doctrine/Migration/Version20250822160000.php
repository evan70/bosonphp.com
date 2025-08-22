<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Persistence\Doctrine\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Create FTS5 virtual table for full-text search in SQLite
 */
final class Version20250822160000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create FTS5 virtual table for full-text search';
    }

    public function up(Schema $schema): void
    {
        // Check if we're using SQLite
        $platform = $this->connection->getDatabasePlatform();
        
        if ($platform->getName() === 'sqlite') {
            // Create FTS5 virtual table
            $this->addSql("CREATE VIRTUAL TABLE doc_pages_fts USING fts5(title, content_rendered, content=doc_pages, content_rowid=rowid)");
            
            // Populate FTS table with existing data
            $this->addSql("INSERT INTO doc_pages_fts(doc_pages_fts) VALUES('rebuild')");
        }
    }

    public function down(Schema $schema): void
    {
        $platform = $this->connection->getDatabasePlatform();
        
        if ($platform->getName() === 'sqlite') {
            $this->addSql("DROP TABLE IF EXISTS doc_pages_fts");
        }
    }
}
