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
final class Version20250702174837 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add documentation menu table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
            CREATE TABLE doc_page_menus (
                id UUID NOT NULL,
                version_id UUID NOT NULL,
                title VARCHAR(255) NOT NULL CHECK (title <> ''),
                sorting_order SMALLINT NOT NULL DEFAULT 0,
                created_at TIMESTAMP(0) WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL,
                updated_at TIMESTAMP(0) WITH TIME ZONE DEFAULT NULL,
                PRIMARY KEY(id)
            )
            SQL);

        $this->addSql(<<<'SQL'
            ALTER TABLE doc_page_menus ADD CONSTRAINT FK_2EBD7EEB4BBC2705
                FOREIGN KEY (version_id)
                REFERENCES doc_page_versions (id) NOT DEFERRABLE INITIALLY IMMEDIATE
            SQL);

        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_2EBD7EEB4BBC2705 ON doc_page_menus (version_id)
            SQL);

        $this->addSql(<<<'SQL'
            CREATE INDEX doc_page_menus_sorting_order_idx ON doc_page_menus (sorting_order)
            SQL);

        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN doc_page_menus.id IS '(DC2Type:App\Domain\Documentation\Menu\PageMenuId)'
            SQL);

        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN doc_page_menus.version_id IS '(DC2Type:App\Domain\Documentation\PageId)'
            SQL);

        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN doc_page_menus.created_at IS '(DC2Type:datetimetz_immutable)'
            SQL);

        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN doc_page_menus.updated_at IS '(DC2Type:datetimetz_immutable)'
            SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
            ALTER TABLE doc_page_menus DROP CONSTRAINT FK_2EBD7EEB4BBC2705
            SQL);

        $this->addSql(<<<'SQL'
            DROP INDEX IDX_2EBD7EEB4BBC2705
            SQL);

        $this->addSql(<<<'SQL'
            DROP TABLE doc_page_menus
            SQL);
    }
}
