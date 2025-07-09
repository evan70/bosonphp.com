<?php

declare(strict_types=1);

namespace App\Documentation\Application\Output\Version;

use App\Documentation\Domain\Version\Status;

enum VersionStatusOutput
{
    case Stable;
    case Dev;
    case Deprecated;
    case Unknown;

    public static function fromStatus(Status $status): self
    {
        return match ($status) {
            Status::Stable => self::Stable,
            Status::Dev => self::Dev,
            Status::Deprecated => self::Deprecated,
            default => self::Unknown,
        };
    }
}
