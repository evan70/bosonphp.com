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
final class Version20250703161455 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add doc_page_versions.status enum column';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
            CREATE TYPE app_domain_documentation_version_status AS ENUM ('stable', 'dev', 'hidden');
            SQL);

        $this->addSql(<<<'SQL'
            ALTER TABLE doc_page_versions ADD status app_domain_documentation_version_status NOT NULL
            SQL);

        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN doc_page_versions.status IS '(DC2Type:App\Domain\Documentation\Version\Status)'
            SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
            ALTER TABLE doc_page_versions DROP status
            SQL);

        $this->addSql(<<<'SQL'
            DROP TYPE app_domain_documentation_version_status
            SQL);
    }
}
