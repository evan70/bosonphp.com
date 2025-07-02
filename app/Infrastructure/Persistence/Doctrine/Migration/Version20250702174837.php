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
                title VARCHAR(255) NOT NULL CHECK (title <> ''),
                sorting_order SMALLINT NOT NULL CHECK (sorting_order >= 0),
                created_at TIMESTAMP(0) WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL,
                updated_at TIMESTAMP(0) WITH TIME ZONE DEFAULT NULL,
                PRIMARY KEY(id)
            )
            SQL);

        $this->addSql(<<<'SQL'
            CREATE INDEX doc_page_menus_sorting_order_idx ON doc_page_menus (sorting_order)
            SQL);

        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN doc_page_menus.id IS '(DC2Type:App\Domain\Documentation\Menu\MenuId)'
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
        $this->addSql('DROP TABLE doc_page_menus');
    }
}
