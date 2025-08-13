<?php

declare(strict_types=1);

namespace App\Documentation\Domain;

use App\Documentation\Domain\Category\Category;
use App\Documentation\Domain\Version\Version;
use App\Shared\Domain\AggregateRootInterface;
use App\Shared\Domain\Date\CreatedDateProvider;
use App\Shared\Domain\Date\CreatedDateProviderInterface;
use App\Shared\Domain\Date\UpdatedDateProvider;
use App\Shared\Domain\Date\UpdatedDateProviderInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'doc_pages')]
#[ORM\InheritanceType('SINGLE_TABLE')]
#[ORM\DiscriminatorColumn(name: 'type', type: 'string', enumType: PageType::class)]
#[ORM\DiscriminatorMap([
    PageType::Document->value => Document::class,
    PageType::Link->value => Link::class,
])]
#[ORM\Index(name: 'doc_pages_uri_idx', columns: ['uri'])]
#[ORM\UniqueConstraint(name: 'doc_pages_uri_unique', columns: ['uri', 'category_id'])]
abstract class Page implements
    AggregateRootInterface,
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
    #[ORM\Column(name: 'title', type: 'string', length: 255, nullable: false)]
    public string $title {
        get => $this->title;
        set(string|\Stringable $value) {
            $title = (string) $value;

            assert($title !== '', 'Documentation page title cannot be empty');

            $this->title = $title;
        }
    }

    /**
     * @var non-empty-lowercase-string
     */
    #[ORM\Column(name: 'hash', type: 'string', nullable: true)]
    public ?string $hash = null;

    /**
     * @var non-empty-string
     */
    #[ORM\Column(name: 'uri', type: 'string', length: 255, nullable: false)]
    public string $uri;

    /**
     * @var int<-32768, 32767>
     */
    #[ORM\Column(name: 'sorting_order', type: 'smallint', options: ['default' => 0])]
    public int $order = 0;

    #[ORM\ManyToOne(targetEntity: Category::class, cascade: ['persist'], fetch: 'EAGER', inversedBy: 'pages')]
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

    /**
     * Generated column
     */
    #[ORM\ManyToOne(targetEntity: Version::class, fetch: 'EAGER', inversedBy: 'categories')]
    #[ORM\JoinColumn(name: 'version_id', referencedColumnName: 'id', nullable: false)]
    public private(set) Version $version {
        get => $this->version;
    }

    /**
     * @api
     */
    public bool $isLink {
        get => $this instanceof Link;
    }

    /**
     * @param non-empty-string $title
     * @param non-empty-string $uri
     * @param int<-32768, 32767> $order
     * @param non-empty-lowercase-string|null $hash
     */
    public function __construct(
        string $title,
        string $uri,
        Category $category,
        int $order = 0,
        ?string $hash = null,
        ?PageId $id = null,
    ) {
        $this->title = $title;
        $this->uri = $uri;
        $this->order = $order;
        $this->hash = $hash;
        $this->category = $category;
        $this->id = $id ?? PageId::new();
    }
}
