<?php

declare(strict_types=1);

namespace App\Domain\Article;

use App\Domain\Article\Category\Category;
use App\Domain\Shared\Date\CreatedDateProvider;
use App\Domain\Shared\Date\CreatedDateProviderInterface;
use App\Domain\Shared\Date\UpdatedDateProvider;
use App\Domain\Shared\Date\UpdatedDateProviderInterface;
use App\Domain\Shared\Id\IdentifiableInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @final impossible to specify "final" attribute natively due
 *        to a Doctrine bug https://github.com/doctrine/orm/issues/7598
 */
#[ORM\Entity]
#[ORM\Table(name: 'articles')]
#[ORM\UniqueConstraint(name: 'article_slug_unique', columns: ['slug'])]
class Article implements
    IdentifiableInterface,
    CreatedDateProviderInterface,
    UpdatedDateProviderInterface
{
    use CreatedDateProvider;
    use UpdatedDateProvider;

    #[ORM\Id]
    #[ORM\Column(type: ArticleId::class)]
    public private(set) ArticleId $id;

    /**
     * @var non-empty-string
     */
    #[ORM\Column(name: 'title')]
    public string $title {
        get => $this->title;
        set (string|\Stringable $value) {
            $this->title = (string) $value;
            $this->slug = $this->slugGenerator->createSlug($this);
        }
    }

    /**
     * @var non-empty-string
     */
    #[ORM\Column(name: 'slug')]
    public private(set) string $slug;

    #[ORM\Embedded(class: Content::class, columnPrefix: 'content_')]
    public Content $content {
        get => $this->content;
        set (string|\Stringable $value) {
            if (!isset($this->content) && $value instanceof Content) {
                $this->content = $value;
                return;
            }

            $this->content->value = $value;
        }
    }

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'articles')]
    #[ORM\JoinColumn(name: 'category_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    public private(set) Category $category;

    /**
     * @param non-empty-string|\Stringable $title
     */
    public function __construct(
        Category $category,
        string|\Stringable $title,
        private readonly ArticleSlugGeneratorInterface $slugGenerator,
        string|\Stringable $content,
        ArticleContentRendererInterface $contentRenderer,
        ?ArticleId $id = null,
    ) {
        $this->category = $category;
        $this->title = (string) $title;
        $this->content = new Content($content, $contentRenderer);
        $this->id = $id ?? ArticleId::new();
    }
}
