<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * @api
 *
 * @internal this is an internal library class, please do not use it in your code
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
            CREATE TABLE blog_articles (
                id UUID NOT NULL,
                category_id UUID NOT NULL,
                title VARCHAR(255) NOT NULL CHECK (title <> ''),
                slug VARCHAR(255) NOT NULL CHECK (slug <> ''),
                content_raw TEXT NOT NULL DEFAULT '',
                content_rendered TEXT NOT NULL DEFAULT '',
                created_at TIMESTAMP(0) WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL,
                updated_at TIMESTAMP(0) WITH TIME ZONE DEFAULT NULL,
                PRIMARY KEY(id)
            )
            SQL);

        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX blog_article_slug_unique ON blog_articles (slug)
            SQL);

        $this->addSql(<<<'SQL'
            ALTER TABLE blog_articles ADD CONSTRAINT FK_BFDD316812469DE2
                FOREIGN KEY (category_id)
                REFERENCES blog_article_categories (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
            SQL);

        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_CB80154F12469DE2 ON blog_articles (category_id)
            SQL);

        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN blog_articles.id IS '(DC2Type:App\Domain\Blog\ArticleId)'
            SQL);

        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN blog_articles.category_id IS '(DC2Type:App\Domain\Blog\Category\ArticleCategoryId)'
            SQL);

        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN blog_articles.created_at IS '(DC2Type:datetimetz_immutable)'
            SQL);

        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN blog_articles.updated_at IS '(DC2Type:datetimetz_immutable)'
            SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
            ALTER TABLE blog_articles DROP CONSTRAINT FK_BFDD316812469DE2
            SQL);

        $this->addSql(<<<'SQL'
            DROP INDEX IDX_CB80154F12469DE2
            SQL);

        $this->addSql(<<<'SQL'
            DROP TABLE blog_articles
            SQL);
    }
}
