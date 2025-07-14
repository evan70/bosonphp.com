<?php

declare(strict_types=1);

namespace App\Documentation\Infrastructure\Persistence\Doctrine\Repository;

use App\Documentation\Domain\PageId;
use App\Documentation\Domain\Search\SearchResult;
use App\Documentation\Domain\Search\SearchResultRepositoryInterface;
use Doctrine\DBAL\Connection;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @api
 *
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal App\Documentation\Infrastructure\Persistence\Doctrine\Repository
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

        $parameters = [
            'query' => $query,
            'version' => $version,
        ];

        $result = $this->connection->executeQuery(<<<'SQL'
            SELECT doc_pages.id, ts_rank(doc_pages.search_vector, to_tsquery('english', :query)) AS rank
            FROM doc_pages
                 LEFT JOIN doc_page_versions versions ON doc_pages.version_id = versions.id
            WHERE versions.name = :version
              AND doc_pages.search_vector @@ to_tsquery('english', :query)
            ORDER BY rank DESC
            LIMIT 10;
            SQL, $parameters);

        while (true) {
            /**
             * @var array{
             *      id: non-empty-string,
             *      rank: float
             *  }|false $record
             */
            $record = $result->fetchAssociative();

            if ($record === false) {
                break;
            }

            yield new SearchResult(
                id: new PageId($record['id']),
                rank: $record['rank'],
            );
        }
    }
}
