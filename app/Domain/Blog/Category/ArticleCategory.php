<?php

declare(strict_types=1);

namespace App\Domain\Blog\Category;

use App\Domain\Blog\Article;
use App\Domain\Shared\Date\CreatedDateProvider;
use App\Domain\Shared\Date\CreatedDateProviderInterface;
use App\Domain\Shared\Date\UpdatedDateProvider;
use App\Domain\Shared\Date\UpdatedDateProviderInterface;
use App\Domain\Shared\Id\IdentifiableInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @final impossible to specify "final" attribute natively due
 *        to a Doctrine bug https://github.com/doctrine/orm/issues/7598
 */
#[ORM\Entity]
#[ORM\Table(name: 'blog_article_categories')]
#[ORM\Index(name: 'blog_article_categories_sorting_order_idx', columns: ['sorting_order'])]
#[ORM\UniqueConstraint(name: 'blog_article_categories_slug_unique', columns: ['slug'])]
class ArticleCategory implements
    IdentifiableInterface,
    CreatedDateProviderInterface,
    UpdatedDateProviderInterface
{
    use CreatedDateProvider;
    use UpdatedDateProvider;

    #[ORM\Id]
    #[ORM\Column(name: 'id', type: ArticleCategoryId::class)]
    public private(set) ArticleCategoryId $id;

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
            $this->slug = $this->slugGenerator->createSlug($this);
        }
    }

    /**
     * @var non-empty-string
     */
    #[ORM\Column(name: 'slug', type: 'string')]
    public private(set) string $slug;

    /**
     * @var int<-32768, 32767>
     */
    #[ORM\Column(name: 'sorting_order', type: 'smallint', options: ['default' => 0])]
    public int $order = 0;

    /**
     * @var iterable<array-key, Article>
     */
    #[ORM\OneToMany(targetEntity: Article::class, mappedBy: 'category', cascade: ['all'])]
    public private(set) iterable $articles;

    /**
     * @param non-empty-string|\Stringable $title
     * @param int<-32768, 32767> $order
     */
    public function __construct(
        string|\Stringable $title,
        private readonly ArticleCategorySlugGeneratorInterface $slugGenerator,
        int $order = 0,
        ?ArticleCategoryId $id = null,
    ) {
        $this->title = $title;
        $this->articles = new ArrayCollection();
        $this->order = $order;
        $this->id = $id ?? ArticleCategoryId::new();
    }
}
