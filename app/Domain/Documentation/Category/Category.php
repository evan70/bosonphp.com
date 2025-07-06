<?php

declare(strict_types=1);

namespace App\Domain\Documentation\Category;

use App\Domain\Documentation\Page;
use App\Domain\Documentation\Version\Version;
use App\Domain\Shared\Date\CreatedDateProvider;
use App\Domain\Shared\Date\CreatedDateProviderInterface;
use App\Domain\Shared\Date\UpdatedDateProvider;
use App\Domain\Shared\Date\UpdatedDateProviderInterface;
use App\Domain\Shared\Id\IdentifiableInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'doc_page_categories')]
#[ORM\Index(name: 'doc_page_categories_sorting_order_idx', columns: ['sorting_order'])]
class Category implements
    IdentifiableInterface,
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
    #[ORM\Column(name: 'title', type: 'string', length: 255)]
    public string $title;

    #[ORM\Column(name: 'description', type: 'text', nullable: true)]
    public ?string $description = null;

    /**
     * @var non-empty-string
     */
    #[ORM\Column(name: 'icon', type: 'string', length: 255, nullable: true)]
    public ?string $icon = null;

    /**
     * @var int<-32768, 32767>
     */
    #[ORM\Column(name: 'sorting_order', type: 'smallint', options: ['default' => 0])]
    public int $order = 0;

    /**
     * @var CategoryPagesSet
     */
    #[ORM\OneToMany(targetEntity: Page::class, mappedBy: 'category', cascade: ['ALL'], fetch: 'EAGER')]
    #[ORM\OrderBy(['id' => 'ASC'])]
    public iterable $pages {
        /** @phpstan-ignore-next-line : PHPStan false-positive */
        get => CategoryPagesSet::for($this, $this->pages);
    }

    #[ORM\ManyToOne(targetEntity: Version::class, cascade: ['ALL'], fetch: 'EAGER', inversedBy: 'categories')]
    #[ORM\JoinColumn(name: 'version_id', referencedColumnName: 'id', nullable: false)]
    public Version $version {
        get => $this->version;
        set(Version $new) {
            /** @phpstan-ignore-next-line : PHPStan false-positive */
            $previous = $this->version ?? null;

            if ($previous !== $new) {
                $previous?->categories->removeElement($this);

                $this->version = $new;
                $new->categories->add($this);
            }
        }
    }

    /**
     * @param non-empty-string $title
     */
    public function __construct(
        Version $version,
        string $title,
        ?string $description = null,
        ?string $icon = null,
        ?CategoryId $id = null,
    ) {
        $this->version = $version;
        $this->title = $title;
        $this->description = $description;
        $this->icon = $icon;
        $this->pages = new CategoryPagesSet($this);
        $this->id = $id ?? CategoryId::new();
    }
}
