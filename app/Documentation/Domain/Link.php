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
class Link extends Page
{
    /**
     * @param non-empty-string $title
     * @param non-empty-string $uri
     * @param int<-32768, 32767> $order
     * @param non-empty-lowercase-string|null $hash
     */
    public function __construct(
        Category $category,
        string $title,
        string $uri,
        int $order = 0,
        ?string $hash = null,
        ?PageId $id = null,
    ) {
        parent::__construct(
            title: $title,
            uri: $uri,
            category: $category,
            order: $order,
            hash: $hash,
            id: $id,
        );
    }
}
