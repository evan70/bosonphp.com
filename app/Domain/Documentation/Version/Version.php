<?php

declare(strict_types=1);

namespace App\Domain\Documentation\Version;

use App\Domain\Documentation\Menu\PageMenu;
use App\Domain\Documentation\Menu\PageMenuSet;
use App\Domain\Shared\Date\CreatedDateProvider;
use App\Domain\Shared\Date\CreatedDateProviderInterface;
use App\Domain\Shared\Date\UpdatedDateProvider;
use App\Domain\Shared\Date\UpdatedDateProviderInterface;
use App\Domain\Shared\Id\IdentifiableInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'doc_page_versions')]
#[ORM\UniqueConstraint(name: 'doc_page_versions_unique_idx', columns: ['title'])]
class Version implements
    IdentifiableInterface,
    CreatedDateProviderInterface,
    UpdatedDateProviderInterface
{
    use CreatedDateProvider;
    use UpdatedDateProvider;

    #[ORM\Id]
    #[ORM\Column(name: 'id', type: VersionId::class)]
    public private(set) VersionId $id;

    /**
     * @var non-empty-string
     */
    #[ORM\Column(name: 'title', type: 'string')]
    public string $title;

    /**
     * @var PageMenuSet
     */
    #[ORM\OneToMany(targetEntity: PageMenu::class, mappedBy: 'version', cascade: ['ALL'], fetch: 'EAGER')]
    #[ORM\OrderBy(['id' => 'ASC'])]
    public iterable $menu {
        /** @phpstan-ignore-next-line : PHPStan false-positive */
        get => PageMenuSet::for($this, $this->menu);
    }

    /**
     * @param non-empty-string $title
     */
    public function __construct(
        string $title,
        ?VersionId $id = null,
    ) {
        $this->title = $title;
        $this->id = $id ?? VersionId::new();
    }
}
