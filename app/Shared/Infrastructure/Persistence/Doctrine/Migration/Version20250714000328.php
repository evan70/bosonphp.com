<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Persistence\Doctrine\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * @api
 *
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal App\Database\Migrations
 */
final class Version20250714000328 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add content search feature';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
            ALTER TABLE doc_pages ADD search_vector tsvector DEFAULT NULL
            SQL);

        $this->addSql(<<<'SQL'
            CREATE INDEX doc_pages_search_idx ON doc_pages USING GIN (search_vector)
            SQL);

        $this->addSql(<<<'SQL'
            CREATE OR REPLACE FUNCTION doc_pages_search_update() RETURNS trigger AS $$
            BEGIN
                NEW.search_vector :=
                        setweight(to_tsvector('english', COALESCE(NEW.title, '')), 'A') ||
                        setweight(to_tsvector('english', COALESCE(NEW.uri, '')), 'B') ||
                        setweight(to_tsvector('english', COALESCE(NEW.content_raw, '')), 'D');
                RETURN NEW;
            END;
            $$ LANGUAGE plpgsql
            SQL);

        $this->addSql(<<<'SQL'
            CREATE TRIGGER doc_pages_search_update_trigger
            BEFORE INSERT OR UPDATE ON doc_pages
            FOR EACH ROW EXECUTE FUNCTION doc_pages_search_update()
            SQL);

        // Touch trigger execution
        $this->addSql(<<<'SQL'
            UPDATE doc_pages SET title = title
            SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
            DROP TRIGGER IF EXISTS doc_pages_search_update_trigger ON doc_pages
            SQL);

        $this->addSql(<<<'SQL'
            DROP FUNCTION doc_pages_search_update
            SQL);

        $this->addSql(<<<'SQL'
            DROP INDEX doc_pages_search_idx
            SQL);

        $this->addSql(<<<'SQL'
            ALTER TABLE doc_pages DROP search_vector
            SQL);
    }
}
