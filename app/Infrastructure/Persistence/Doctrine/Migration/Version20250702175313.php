<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * @api
 *
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal App\Database\Migrations
 */
final class Version20250702175313 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add documentation pages table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
            CREATE TABLE doc_pages (
                id UUID NOT NULL,
                menu_id UUID DEFAULT NULL,
                title VARCHAR(255) NOT NULL CHECK (title <> ''),
                slug VARCHAR(255) NOT NULL CHECK (slug <> ''),
                type VARCHAR(255) NOT NULL CHECK (type <> ''),
                content_rendered TEXT DEFAULT '',
                content_raw TEXT DEFAULT '',
                created_at TIMESTAMP(0) WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL,
                updated_at TIMESTAMP(0) WITH TIME ZONE DEFAULT NULL,
                PRIMARY KEY(id)
            )
            SQL);

        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_4F9D8823CCD7E912 ON doc_pages (menu_id)
            SQL);

        $this->addSql(<<<'SQL'
            CREATE INDEX doc_pages_url_idx ON doc_pages (slug)
            SQL);

        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN doc_pages.id IS '(DC2Type:App\Domain\Documentation\PageId)'
            SQL);

        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN doc_pages.menu_id IS '(DC2Type:App\Domain\Documentation\Menu\PageMenuId)'
            SQL);

        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN doc_pages.created_at IS '(DC2Type:datetimetz_immutable)'
            SQL);

        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN doc_pages.updated_at IS '(DC2Type:datetimetz_immutable)'
            SQL);

        $this->addSql(<<<'SQL'
            ALTER TABLE doc_pages ADD CONSTRAINT FK_4F9D8823CCD7E912
                FOREIGN KEY (menu_id)
                REFERENCES doc_page_menus (id) NOT DEFERRABLE INITIALLY IMMEDIATE
            SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
            ALTER TABLE doc_pages DROP CONSTRAINT FK_4F9D8823CCD7E912
            SQL);

        $this->addSql(<<<'SQL'
            DROP TABLE doc_pages
            SQL);
    }
}
