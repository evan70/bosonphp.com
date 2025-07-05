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
        return 'Add documentation categories table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
            CREATE TABLE doc_page_categories (
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
            ALTER TABLE doc_page_categories ADD CONSTRAINT FK_2EBD7EEB4BBC2705
                FOREIGN KEY (version_id)
                REFERENCES doc_page_versions (id) NOT DEFERRABLE INITIALLY IMMEDIATE
            SQL);

        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_C954E54C4BBC2705 ON doc_page_categories (version_id)
            SQL);

        $this->addSql(<<<'SQL'
            CREATE INDEX doc_page_categories_sorting_order_idx ON doc_page_categories (sorting_order)
            SQL);

        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN doc_page_categories.id IS '(DC2Type:App\Domain\Documentation\Category\CategoryId)'
            SQL);

        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN doc_page_categories.version_id IS '(DC2Type:App\Domain\Documentation\Version\VersionId)'
            SQL);

        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN doc_page_categories.created_at IS '(DC2Type:datetimetz_immutable)'
            SQL);

        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN doc_page_categories.updated_at IS '(DC2Type:datetimetz_immutable)'
            SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
            ALTER TABLE doc_page_categories DROP CONSTRAINT FK_2EBD7EEB4BBC2705
            SQL);

        $this->addSql(<<<'SQL'
            DROP INDEX IDX_C954E54C4BBC2705
            SQL);

        $this->addSql(<<<'SQL'
            DROP TABLE doc_page_categories
            SQL);
    }
}
