<?php

declare(strict_types=1);

namespace App\Domain\Documentation;

use App\Domain\Documentation\Category\Category;
use App\Domain\Shared\Date\CreatedDateProvider;
use App\Domain\Shared\Date\CreatedDateProviderInterface;
use App\Domain\Shared\Date\UpdatedDateProvider;
use App\Domain\Shared\Date\UpdatedDateProviderInterface;
use App\Domain\Shared\Id\IdentifiableInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'doc_pages')]
#[ORM\InheritanceType('SINGLE_TABLE')]
#[ORM\DiscriminatorColumn(name: 'type', type: 'string', enumType: PageType::class)]
#[ORM\DiscriminatorMap([
    PageType::Document->value => PageDocument::class,
    PageType::Link->value => PageLink::class,
])]
#[ORM\Index(name: 'doc_pages_uri_idx', columns: ['uri'])]
abstract class Page implements
    IdentifiableInterface,
    CreatedDateProviderInterface,
    UpdatedDateProviderInterface
{
    use CreatedDateProvider;
    use UpdatedDateProvider;

    #[ORM\Id]
    #[ORM\Column(name: 'id', type: PageId::class)]
    public private(set) PageId $id;

    /**
     * @var non-empty-string
     */
    #[ORM\Column(name: 'title', type: 'string', length: 255)]
    public string $title {
        get => $this->title;
        set(string|\Stringable $value) {
            $title = (string) $value;

            assert($title !== '', 'Documentation page title cannot be empty');

            $this->title = $title;
            $this->uri = $this->slugGenerator->createSlug($this);
        }
    }

    /**
     * @var non-empty-string
     */
    #[ORM\Column(name: 'uri', length: 255)]
    public private(set) string $uri;

    #[ORM\ManyToOne(targetEntity: Category::class, cascade: ['ALL'], fetch: 'EAGER', inversedBy: 'pages')]
    #[ORM\JoinColumn(name: 'category_id', referencedColumnName: 'id', nullable: false)]
    public Category $category {
        get => $this->category;
        set(Category $new) {
            /** @phpstan-ignore-next-line : PHPStan false-positive */
            $previous = $this->category ?? null;

            if ($previous !== $new) {
                $previous?->pages->removeElement($this);

                $this->category = $new;
                $new->pages->add($this);
            }
        }
    }

    public bool $isLink {
        get => $this instanceof PageLink;
    }

    /**
     * @param non-empty-string $title
     */
    public function __construct(
        Category $category,
        string $title,
        protected readonly PageSlugGeneratorInterface $slugGenerator,
        ?PageId $id = null,
    ) {
        $this->title = $title;
        $this->category = $category;
        $this->id = $id ?? PageId::new();
    }
}
