<?php

declare(strict_types=1);

namespace App\Blog\Domain\Category;

use App\Blog\Domain\Article;
use App\Shared\Domain\AggregateRootInterface;
use App\Shared\Domain\Date\CreatedDateProvider;
use App\Shared\Domain\Date\CreatedDateProviderInterface;
use App\Shared\Domain\Date\UpdatedDateProvider;
use App\Shared\Domain\Date\UpdatedDateProviderInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @final impossible to specify "final" attribute natively due
 *        to a Doctrine bug https://github.com/doctrine/orm/issues/7598
 */
#[ORM\Entity]
#[ORM\Table(name: 'blog_article_categories')]
#[ORM\Index(name: 'blog_article_categories_sorting_order_idx', columns: ['sorting_order'])]
#[ORM\UniqueConstraint(name: 'blog_article_categories_uri_unique', columns: ['uri'])]
class Category implements
    AggregateRootInterface,
    CreatedDateProviderInterface,
    UpdatedDateProviderInterface
{
    use CreatedDateProvider;
    use UpdatedDateProvider;

    #[ORM\Id]
    #[ORM\Column(name: 'id', type: CategoryId::class)]
    public private(set) CategoryId $id;

    /**
     * @var non-empty-string
     */
    #[ORM\Column(name: 'title', type: 'string')]
    public string $title {
        get => $this->title;
        set(string|\Stringable $value) {
            $title = (string) $value;

            assert($title !== '', 'Category title cannot be empty');

            $this->title = $title;
            $this->uri = $this->slugGenerator->createSlug($this);
        }
    }

    /**
     * @var non-empty-string
     */
    #[ORM\Column(name: 'uri', type: 'string')]
    public private(set) string $uri;

    /**
     * @var int<-32768, 32767>
     */
    #[ORM\Column(name: 'sorting_order', type: 'smallint', options: ['default' => 0])]
    public int $order = 0;

    /**
     * @var CategoryArticleSet
     */
    #[ORM\OneToMany(targetEntity: Article::class, mappedBy: 'category', cascade: ['all'])]
    public iterable $articles {
        /** @phpstan-ignore-next-line : PHPStan false-positive */
        get => CategoryArticleSet::for($this, $this->articles);
    }

    /**
     * @param non-empty-string|\Stringable $title
     * @param int<-32768, 32767> $order
     */
    public function __construct(
        string|\Stringable $title,
        private readonly CategorySlugGeneratorInterface $slugGenerator,
        int $order = 0,
        ?CategoryId $id = null,
    ) {
        $this->title = $title;
        $this->articles = new CategoryArticleSet($this);
        $this->order = $order;
        $this->id = $id ?? CategoryId::new();
    }
}
