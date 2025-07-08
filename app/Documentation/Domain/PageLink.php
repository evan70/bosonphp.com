<?php

declare(strict_types=1);

namespace App\Documentation\Domain;

use App\Documentation\Domain\Category\Category;
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
    #[ORM\Column(name: 'uri', type: 'non_empty_string', length: 255, nullable: false)]
    public string $uri;

    /**
     * @param non-empty-string $title
     * @param non-empty-string $uri
     * @param int<-32768, 32767> $order
     */
    public function __construct(
        Category $category,
        string $title,
        string $uri,
        int $order = 0,
        ?PageId $id = null,
    ) {
        $this->uri = $uri;

        parent::__construct(
            title: $title,
            category: $category,
            order: $order,
            id: $id,
        );
    }
}
