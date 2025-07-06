<?php

declare(strict_types=1);

namespace App\Domain\Documentation;

enum PageType: string
{
    case Document = 'document';
    case Link = 'link';
}
