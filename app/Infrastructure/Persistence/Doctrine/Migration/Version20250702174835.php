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
final class Version20250702174835 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add documentation versions table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
            CREATE TABLE doc_page_versions (
                id UUID NOT NULL,
                title VARCHAR(255) NOT NULL CHECK ( title <> '' ),
                created_at TIMESTAMP(0) WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL,
                updated_at TIMESTAMP(0) WITH TIME ZONE DEFAULT NULL,
                PRIMARY KEY(id)
            )
            SQL);

        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX doc_page_versions_unique_idx ON doc_page_versions (title)
            SQL);

        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN doc_page_versions.id IS '(DC2Type:App\Domain\Documentation\PageId)'
            SQL);

        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN doc_page_versions.created_at IS '(DC2Type:datetimetz_immutable)'
            SQL);

        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN doc_page_versions.updated_at IS '(DC2Type:datetimetz_immutable)'
            SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
            DROP TABLE doc_page_versions
            SQL);
    }
}
