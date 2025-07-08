<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Persistence\Doctrine\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * @api
 *
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal App\Shared\Infrastructure\Persistence\Doctrine\Migration
 */
final class Version20240830211215 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add account integrations table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
            CREATE TABLE account_integrations (
                id UUID NOT NULL,
                account_id UUID DEFAULT NULL,
                dsn VARCHAR(255) NOT NULL CHECK(dsn ~* '^[\w+-.]+://.+?$'),
                external_id VARCHAR(255) NOT NULL CHECK(dsn <> ''),
                login VARCHAR(255) DEFAULT NULL,
                email VARCHAR(255) DEFAULT NULL,
                avatar VARCHAR(255) DEFAULT NULL,
                created_at TIMESTAMP(0) WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL,
                updated_at TIMESTAMP(0) WITH TIME ZONE DEFAULT NULL,
                PRIMARY KEY(id)
            )
            SQL);

        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_E5F67AEC9B6B5FBA ON account_integrations (account_id)
            SQL);

        $this->addSql(<<<'SQL'
            ALTER TABLE account_integrations ADD CONSTRAINT FK_E5F67AEC9B6B5FBA
                FOREIGN KEY (account_id) REFERENCES accounts (id)
                    ON DELETE CASCADE
                    NOT DEFERRABLE INITIALLY IMMEDIATE
            SQL);

        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN account_integrations.id IS '(DC2Type:App\Account\Domain\Integration\IntegrationId)'
            SQL);

        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN account_integrations.account_id IS '(DC2Type:App\Account\Domain\AccountId)'
            SQL);

        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN account_integrations.created_at IS '(DC2Type:datetimetz_immutable)'
            SQL);

        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN account_integrations.updated_at IS '(DC2Type:datetimetz_immutable)'
            SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
            ALTER TABLE account_integrations DROP CONSTRAINT FK_E5F67AEC9B6B5FBA
            SQL);

        $this->addSql(<<<'SQL'
            DROP TABLE account_integrations
            SQL);
    }
}
