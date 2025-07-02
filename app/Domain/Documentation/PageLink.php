<?php

declare(strict_types=1);

namespace App\Domain\Documentation;

use Doctrine\ORM\Mapping as ORM;

/**
 * @final impossible to specify "final" attribute natively due
 *        to a Doctrine bug https://github.com/doctrine/orm/issues/7598
 */
#[ORM\Entity]
class PageLink extends Page
{
}
