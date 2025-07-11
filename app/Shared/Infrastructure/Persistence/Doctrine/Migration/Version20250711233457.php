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
final class Version20250711233457 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add doc version, category and page hashes';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
            ALTER TABLE doc_page_categories ADD hash VARCHAR(255) DEFAULT NULL
            SQL);

        $this->addSql(<<<'SQL'
            ALTER TABLE doc_page_versions ADD hash VARCHAR(255) DEFAULT NULL
            SQL);

        $this->addSql(<<<'SQL'
            ALTER TABLE doc_pages ADD hash VARCHAR(255) DEFAULT NULL
            SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
            ALTER TABLE doc_pages DROP hash
            SQL);

        $this->addSql(<<<'SQL'
            ALTER TABLE doc_page_categories DROP hash
            SQL);

        $this->addSql(<<<'SQL'
            ALTER TABLE doc_page_versions DROP hash
            SQL);
    }
}
