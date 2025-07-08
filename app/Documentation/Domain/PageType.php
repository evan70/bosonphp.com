<?php

declare(strict_types=1);

namespace App\Documentation\Domain;

enum PageType: string
{
    case Document = 'document';
    case Link = 'link';
}
