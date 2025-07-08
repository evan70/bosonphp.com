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
final class Version20250701164835 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create article categories';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
            CREATE TABLE blog_article_categories (
                id UUID NOT NULL,
                title VARCHAR(255) NOT NULL CHECK (title <> ''),
                slug VARCHAR(255) NOT NULL CHECK (slug <> ''),
                sorting_order SMALLINT NOT NULL DEFAULT 0,
                created_at TIMESTAMP(0) WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL,
                updated_at TIMESTAMP(0) WITH TIME ZONE DEFAULT NULL,
                PRIMARY KEY(id)
            )
            SQL);

        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX blog_article_categories_slug_unique ON blog_article_categories (slug)
            SQL);

        $this->addSql(<<<'SQL'
            CREATE INDEX blog_article_categories_sorting_order_idx ON blog_article_categories (sorting_order)
            SQL);

        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN blog_article_categories.id IS '(DC2Type:App\Blog\Domain\Category\CategoryId)'
            SQL);

        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN blog_article_categories.created_at IS '(DC2Type:datetimetz_immutable)'
            SQL);

        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN blog_article_categories.updated_at IS '(DC2Type:datetimetz_immutable)'
            SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
            DROP TABLE blog_article_categories
            SQL);
    }
}
