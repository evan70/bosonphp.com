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
final class Version20250709135133 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create generated version_id column on doc_pages';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
            CREATE OR REPLACE FUNCTION before_insert_update_doc_pages()
                RETURNS trigger LANGUAGE plpgsql AS $$
            BEGIN
                NEW.version_id := (SELECT version_id
                                   FROM doc_page_categories
                                   WHERE doc_page_categories.id = NEW.category_id);
                RETURN NEW;
            END; $$
            SQL);

        $this->addSql(<<<'SQL'
            ALTER TABLE doc_pages
                ADD version_id UUID NOT NULL
            SQL);

        $this->addSql(<<<'SQL'
            CREATE OR REPLACE TRIGGER before_insert_update_doc_pages BEFORE INSERT OR UPDATE ON doc_pages
            FOR EACH ROW EXECUTE FUNCTION before_insert_update_doc_pages();
            SQL);

        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN doc_pages.version_id IS '(DC2Type:App\Documentation\Domain\Version\VersionId)'
            SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
           ALTER TABLE doc_pages DROP version_id
           SQL);

        $this->addSql(<<<'SQL'
            DROP TRIGGER IF EXISTS before_insert_update_doc_pages ON doc_pages;
            SQL);

        $this->addSql(<<<'SQL'
            DROP FUNCTION before_insert_update_doc_pages
            SQL);
    }
}
