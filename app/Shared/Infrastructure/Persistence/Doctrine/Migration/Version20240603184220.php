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
final class Version20240603184220 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create accounts table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
            CREATE TABLE accounts (
                id UUID NOT NULL,
                login VARCHAR(255) NOT NULL CHECK(login <> ''),
                password VARCHAR(255) DEFAULT NULL,
                roles VARCHAR(255)[] DEFAULT '{}' NOT NULL,
                created_at TIMESTAMP(0) WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL,
                updated_at TIMESTAMP(0) WITH TIME ZONE DEFAULT NULL,
                PRIMARY KEY(id)
            )
            SQL);

        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX login_unique ON accounts (login)
            SQL);

        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN accounts.id IS '(DC2Type:App\Account\Domain\AccountId)'
            SQL);

        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN accounts.roles IS '(DC2Type:string[])'
            SQL);

        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN accounts.created_at IS '(DC2Type:datetimetz_immutable)'
            SQL);

        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN accounts.updated_at IS '(DC2Type:datetimetz_immutable)'
            SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
            DROP TABLE accounts
            SQL);
    }
}
