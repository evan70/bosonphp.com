<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * @api
 *
 * @internal this is an internal library class, please do not use it in your code.
 * @psalm-internal App\Infrastructure\Persistence\Doctrine\Migration
 */
final class Version20250701164836 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add articles table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
            CREATE TABLE articles (
                id UUID NOT NULL,
                title VARCHAR(255) NOT NULL CHECK (title <> ''),
                slug VARCHAR(255) NOT NULL CHECK (slug <> ''),
                created_at TIMESTAMP(0) WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL,
                updated_at TIMESTAMP(0) WITH TIME ZONE DEFAULT NULL,
                PRIMARY KEY(id)
            )
            SQL);

        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX slug_unique ON articles (slug)
            SQL);

        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN articles.created_at IS '(DC2Type:datetimetz_immutable)'
            SQL);

        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN articles.updated_at IS '(DC2Type:datetimetz_immutable)'
            SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
            DROP TABLE articles
            SQL);
    }
}
