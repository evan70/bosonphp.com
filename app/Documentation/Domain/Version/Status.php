<?php

declare(strict_types=1);

namespace App\Documentation\Domain\Version;

enum Status: string
{
    case Stable = 'stable';
    case Dev = 'dev';
    case Deprecated = 'deprecated';
    case Hidden = 'hidden';

    public const Status DEFAULT = Status::Stable;
}
