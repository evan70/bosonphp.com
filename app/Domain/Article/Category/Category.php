<?php

declare(strict_types=1);

namespace App\Domain\Article\Category;

use App\Domain\Article\Article;
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
#[ORM\Table(name: 'article_categories')]
#[ORM\UniqueConstraint(name: 'article_category_slug_unique', columns: ['slug'])]
class Category implements
    IdentifiableInterface,
    CreatedDateProviderInterface,
    UpdatedDateProviderInterface
{
    use CreatedDateProvider;
    use UpdatedDateProvider;

    #[ORM\Id]
    #[ORM\Column(type: CategoryId::class)]
    public private(set) CategoryId $id;

    /**
     * @var non-empty-string
     */
    #[ORM\Column(name: 'title')]
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
    #[ORM\Column(name: 'slug')]
    public private(set) string $slug;

    /**
     * @var iterable<array-key, Article>
     */
    #[ORM\OneToMany(targetEntity: Article::class, mappedBy: 'category', cascade: ['all'])]
    public private(set) iterable $articles;

    /**
     * @param non-empty-string|\Stringable $title
     */
    public function __construct(
        string|\Stringable $title,
        private readonly CategorySlugGeneratorInterface $slugGenerator,
        ?CategoryId $id = null,
    ) {
        $this->title = $title;
        $this->articles = new ArrayCollection();
        $this->id = $id ?? CategoryId::new();
    }
}
