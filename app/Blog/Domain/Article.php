<?php

declare(strict_types=1);

namespace App\Blog\Domain;

use App\Blog\Domain\Category\Category;
use App\Shared\Domain\Date\CreatedDateProvider;
use App\Shared\Domain\Date\CreatedDateProviderInterface;
use App\Shared\Domain\Date\UpdatedDateProvider;
use App\Shared\Domain\Date\UpdatedDateProviderInterface;
use App\Shared\Domain\Id\IdentifiableInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\String\TruncateMode;
use Symfony\Component\String\UnicodeString;

/**
 * @final impossible to specify "final" attribute natively due
 *        to a Doctrine bug https://github.com/doctrine/orm/issues/7598
 */
#[ORM\Entity]
#[ORM\Table(name: 'blog_articles')]
#[ORM\UniqueConstraint(name: 'blog_article_uri_unique', columns: ['uri'])]
class Article implements
    IdentifiableInterface,
    CreatedDateProviderInterface,
    UpdatedDateProviderInterface
{
    use CreatedDateProvider;
    use UpdatedDateProvider;

    #[ORM\Id]
    #[ORM\Column(name: 'id', type: ArticleId::class)]
    public private(set) ArticleId $id;

    /**
     * @var non-empty-string
     */
    #[ORM\Column(name: 'title', type: 'string', length: 255)]
    public string $title {
        get => $this->title;
        set(string|\Stringable $value) {
            $title = (string) $value;

            assert($title !== '', 'Article title cannot be empty');

            $this->title = $title;
            $this->uri = $this->slugGenerator->createSlug($this);
        }
    }

    /**
     * @var non-empty-string
     */
    #[ORM\Column(name: 'uri', type: 'string')]
    public private(set) string $uri;

    #[ORM\Embedded(class: ArticleContent::class, columnPrefix: 'content_')]
    public ArticleContent $content {
        get => $this->content;
        set(string|\Stringable $value) {
            /** @phpstan-ignore-next-line : PHPStan false-positive in isset() */
            if (!isset($this->content) && $value instanceof ArticleContent) {
                $this->content = $value;

                return;
            }

            $this->content->value = $value;
        }
    }

    #[ORM\Column(name: 'preview', type: 'text', options: ['default' => ''])]
    public string $preview;

    #[ORM\ManyToOne(targetEntity: Category::class, cascade: ['ALL'], fetch: 'EAGER', inversedBy: 'articles')]
    #[ORM\JoinColumn(name: 'category_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    public Category $category {
        get => $this->category;
        set(Category $new) {
            /** @phpstan-ignore-next-line : PHPStan false-positive */
            $previous = $this->category ?? null;

            if ($previous !== $new) {
                $previous?->articles->removeElement($this);

                $this->category = $new;
                $new->articles->add($this);
            }
        }
    }

    /**
     * @param non-empty-string|\Stringable $title
     */
    public function __construct(
        Category $category,
        string|\Stringable $title,
        private readonly ArticleSlugGeneratorInterface $slugGenerator,
        string|\Stringable $content,
        ArticleContentRendererInterface $contentRenderer,
        string|\Stringable|null $preview = null,
        ?ArticleId $id = null,
    ) {
        $this->category = $category;
        $this->title = $title;

        $this->content = new ArticleContent(
            value: $content,
            contentRenderer: $contentRenderer,
        );

        $this->preview = (string) ($preview ?? new UnicodeString(
            string: \strip_tags($this->content->rendered),
        )
            ->truncate(200, cut: TruncateMode::WordAfter));

        $this->id = $id ?? ArticleId::new();
    }
}
