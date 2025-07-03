<?php

declare(strict_types=1);

namespace App\Domain\Documentation\Version;

enum Status: string
{
    case Stable = 'stable';
    case Dev = 'dev';
    case Hidden = 'hidden';
}
