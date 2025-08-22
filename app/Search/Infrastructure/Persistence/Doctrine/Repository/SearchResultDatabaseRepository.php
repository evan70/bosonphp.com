<?php

declare(strict_types=1);

namespace App\Search\Infrastructure\Persistence\Doctrine\Repository;

use App\Search\Domain\SearchResult;
use App\Search\Domain\SearchResultId;
use App\Search\Domain\SearchResultRepositoryInterface;
use Doctrine\DBAL\Connection;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @api
 *
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal App\Search\Infrastructure\Persistence\Doctrine\Repository
 */
final readonly class SearchResultDatabaseRepository implements SearchResultRepositoryInterface
{
    private Connection $connection;

    public function __construct(
        private ManagerRegistry $registry
    ) {
        $this->connection = new \ReflectionClass(Connection::class)
            ->newLazyProxy(function (): Connection {
                $connection = $this->registry->getConnection();

                assert($connection instanceof Connection);

                return $connection;
            });
    }

    public function search(string $version, string $query, int $limit = self::DEFAULT_SEARCH_LIMIT): iterable
    {
        if ($query === '' || $version === '' || $limit < 1) {
            return [];
        }

        // Check if we can use FTS5 (SQLite Full-Text Search)
        $platform = $this->connection->getDatabasePlatform();

        if ($platform->getName() === 'sqlite') {
            // Try FTS5 first, fallback to LIKE if FTS table doesn't exist
            try {
                $builder = $this->connection->createQueryBuilder()
                    ->from('doc_pages_fts', 'fts')
                    ->addSelect('doc_pages.id')
                    ->addSelect('doc_pages.title')
                    ->addSelect('doc_pages.uri')
                    ->addSelect('doc_pages.content_rendered')
                    ->addSelect('versions.name AS version')
                    ->addSelect('categories.title AS category')
                    ->addSelect('(-fts.rank) AS rank') // FTS5 uses negative ranking, so we flip it
                    ->leftJoin('fts', 'doc_pages', 'doc_pages', 'fts.rowid = doc_pages.rowid')
                    ->leftJoin('doc_pages', 'doc_page_versions', 'versions', 'doc_pages.version_id = versions.id')
                    ->leftJoin('doc_pages', 'doc_page_categories', 'categories', 'doc_pages.category_id = categories.id')
                    ->andWhere('versions.name = :version')
                    ->andWhere('fts.doc_pages_fts MATCH :query')
                    ->orderBy('fts.rank', 'ASC') // ASC because FTS5 rank is negative (better = more negative)
                    ->setMaxResults($limit)
                    ->setParameter('version', $version)
                    ->setParameter('query', $query)
                ;

                // Test the query to see if FTS table exists
                $testBuilder = clone $builder;
                $testBuilder->setMaxResults(1);
                $testBuilder->executeQuery();

            } catch (\Exception) {
                // Fallback to LIKE search if FTS table doesn't exist
                $builder = $this->connection->createQueryBuilder()
                    ->from('doc_pages')
                    ->addSelect('doc_pages.id')
                    ->addSelect('doc_pages.title')
                    ->addSelect('doc_pages.uri')
                    ->addSelect('doc_pages.content_rendered')
                    ->addSelect('versions.name AS version')
                    ->addSelect('categories.title AS category')
                    ->addSelect('1.0 AS rank')
                    ->leftJoin('doc_pages', 'doc_page_versions', 'versions', 'doc_pages.version_id = versions.id')
                    ->leftJoin('doc_pages', 'doc_page_categories', 'categories', 'doc_pages.category_id = categories.id')
                    ->andWhere('versions.name = :version')
                    ->andWhere('(doc_pages.title LIKE :query_like OR doc_pages.content_rendered LIKE :query_like)')
                    ->orderBy('doc_pages.title', 'ASC')
                    ->setMaxResults($limit)
                    ->setParameter('version', $version)
                    ->setParameter('query', $query)
                    ->setParameter('query_like', '%' . $query . '%')
                ;
            }
        } else {
            // For other databases, use LIKE search
            $builder = $this->connection->createQueryBuilder()
                ->from('doc_pages')
                ->addSelect('doc_pages.id')
                ->addSelect('doc_pages.title')
                ->addSelect('doc_pages.uri')
                ->addSelect('doc_pages.content_rendered')
                ->addSelect('versions.name AS version')
                ->addSelect('categories.title AS category')
                ->addSelect('1.0 AS rank')
                ->leftJoin('doc_pages', 'doc_page_versions', 'versions', 'doc_pages.version_id = versions.id')
                ->leftJoin('doc_pages', 'doc_page_categories', 'categories', 'doc_pages.category_id = categories.id')
                ->andWhere('versions.name = :version')
                ->andWhere('(doc_pages.title LIKE :query_like OR doc_pages.content_rendered LIKE :query_like)')
                ->orderBy('doc_pages.title', 'ASC')
                ->setMaxResults($limit)
                ->setParameter('version', $version)
                ->setParameter('query', $query)
                ->setParameter('query_like', '%' . $query . '%')
            ;
        }

        /**
         * @var array{
         *      id: non-empty-string,
         *      version: non-empty-string,
         *      category: non-empty-string,
         *      title: non-empty-string,
         *      uri: non-empty-string,
         *      content_rendered: string,
         *      rank: float
         *  } $record
         */
        foreach ($builder->fetchAllAssociative() as $record) {
            yield new SearchResult(
                id: new SearchResultId($record['id']),
                category: $record['category'],
                version: $record['version'],
                title: $record['title'],
                uri: $record['uri'],
                content: $record['content_rendered'],
                rank: $record['rank'],
            );
        }
    }
}
