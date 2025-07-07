<?php

declare(strict_types=1);

namespace App\Domain\Documentation;

use App\Domain\Documentation\Category\Category;
use Doctrine\ORM\Mapping as ORM;

/**
 * @final impossible to specify "final" attribute natively due
 *        to a Doctrine bug https://github.com/doctrine/orm/issues/7598
 */
#[ORM\Entity]
class PageLink extends Page
{
    /**
     * @var non-empty-string
     */
    #[ORM\Column(name: 'title', type: 'string', length: 255)]
    public string $title;

    /**
     * @var non-empty-string
     */
    #[ORM\Column(name: 'uri', length: 255)]
    public string $uri;

    /**
     * @param non-empty-string $title
     * @param non-empty-string $uri
     */
    public function __construct(
        Category $category,
        string $title,
        string $uri,
        ?PageId $id = null,
    ) {
        $this->title = $title;
        $this->uri = $uri;

        parent::__construct($category, $id);
    }
}
