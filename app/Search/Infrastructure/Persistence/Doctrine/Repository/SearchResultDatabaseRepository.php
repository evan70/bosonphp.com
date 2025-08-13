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

        $builder = $this->connection->createQueryBuilder()
            ->from('doc_pages')
            ->addSelect('doc_pages.id')
            ->addSelect('doc_pages.title')
            ->addSelect('doc_pages.uri')
            ->addSelect('doc_pages.content_rendered')
            ->addSelect('versions.name AS version')
            ->addSelect('categories.title AS category')
            ->addSelect('ts_rank(doc_pages.search_vector, to_tsquery(\'english\', quote_literal(:query))) AS rank')
            ->leftJoin('doc_pages', 'doc_page_versions', 'versions', 'doc_pages.version_id = versions.id')
            ->leftJoin('doc_pages', 'doc_page_categories', 'categories', 'doc_pages.category_id = categories.id')
            ->andWhere('versions.name = :version')
            ->andWhere('doc_pages.search_vector @@ to_tsquery(\'english\', quote_literal(:query))')
            ->orderBy('rank', 'DESC')
            ->setMaxResults($limit)
            ->setParameter('version', $version)
            ->setParameter('query', $query)
        ;

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
