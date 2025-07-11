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
final class Version20250711233148 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add doc_pages.version_id foreign key';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
            ALTER TABLE doc_pages ADD CONSTRAINT FK_4F9D88234BBC2705
                FOREIGN KEY (version_id)
                REFERENCES doc_page_versions (id) NOT DEFERRABLE INITIALLY IMMEDIATE
            SQL);

        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_4F9D88234BBC2705 ON doc_pages (version_id)
            SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
            ALTER TABLE doc_pages DROP CONSTRAINT FK_4F9D88234BBC2705
            SQL);

        $this->addSql(<<<'SQL'
            DROP INDEX IDX_4F9D88234BBC2705
            SQL);
    }
}
