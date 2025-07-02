<?php

declare(strict_types=1);

namespace App\Domain\Documentation;

use App\Domain\Documentation\Menu\Menu;
use App\Domain\Shared\Date\CreatedDateProvider;
use App\Domain\Shared\Date\CreatedDateProviderInterface;
use App\Domain\Shared\Date\UpdatedDateProvider;
use App\Domain\Shared\Date\UpdatedDateProviderInterface;
use App\Domain\Shared\Id\IdentifiableInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'doc_pages')]
#[ORM\InheritanceType('SINGLE_TABLE')]
#[ORM\DiscriminatorColumn(name: 'type', type: 'string')]
#[ORM\DiscriminatorMap([
    'document' => PageDocument::class,
    'link' => PageLink::class,
])]
#[ORM\Index(name: 'doc_pages_url_idx', columns: ['slug'])]
#[ORM\Index(name: 'doc_pages_sorting_order_idx', columns: ['sorting_order'])]
abstract class Page implements
    IdentifiableInterface,
    CreatedDateProviderInterface,
    UpdatedDateProviderInterface
{
    use CreatedDateProvider;
    use UpdatedDateProvider;

    #[ORM\Id]
    #[ORM\Column(type: PageId::class)]
    public private(set) PageId $id;

    /**
     * @var non-empty-string
     */
    #[ORM\Column(type: 'string', length: 255)]
    public string $title {
        get => $this->title;
        set(string|\Stringable $value) {
            $title = (string) $value;

            assert($title !== '', 'Documentation page title cannot be empty');

            $this->title = $title;
            $this->slug = $this->slugGenerator->createSlug($this);
        }
    }

    /**
     * @var non-empty-string
     */
    #[ORM\Column(name: 'slug', length: 255)]
    public private(set) string $slug;

    /**
     * @var int<0, 32767>
     */
    #[ORM\Column(name: 'sorting_order', type: 'smallint')]
    public int $order = 0 {
        get => $this->order;
        set {
            if ($value < 0 || $value > 32767) {
                throw new \InvalidArgumentException('Order must be in range [0 ... 32767]');
            }

            $this->order = $value;
        }
    }

    #[ORM\ManyToOne(targetEntity: Menu::class, inversedBy: 'pages')]
    #[ORM\JoinColumn(name: 'menu_id', referencedColumnName: 'id')]
    public private(set) Menu $menu;

    /**
     * @param non-empty-string $title
     */
    public function __construct(
        Menu $menu,
        string $title,
        private readonly PageSlugGeneratorInterface $slugGenerator,
        ?PageId $id = null,
    ) {
        $this->title = $title;
        $this->menu = $menu;
        $this->id = $id ?? PageId::new();
    }
}
