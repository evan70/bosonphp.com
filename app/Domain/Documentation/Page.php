<?php

declare(strict_types=1);

namespace App\Domain\Documentation;

use App\Domain\Documentation\Menu\PageMenu;
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
            $this->slug = $this->slugGenerator->createSlug($this);
        }
    }

    /**
     * @var non-empty-string
     */
    #[ORM\Column(name: 'slug', length: 255)]
    public private(set) string $slug;

    #[ORM\ManyToOne(targetEntity: PageMenu::class, cascade: ['ALL'], fetch: 'EAGER', inversedBy: 'pages')]
    #[ORM\JoinColumn(name: 'menu_id', referencedColumnName: 'id')]
    public private(set) PageMenu $menu;

    /**
     * @param non-empty-string $title
     */
    public function __construct(
        PageMenu $menu,
        string $title,
        protected readonly PageSlugGeneratorInterface $slugGenerator,
        ?PageId $id = null,
    ) {
        $this->title = $title;
        $this->menu = $menu;
        $this->id = $id ?? PageId::new();
    }
}
