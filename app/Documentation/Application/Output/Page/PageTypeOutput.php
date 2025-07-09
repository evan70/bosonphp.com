<?php

declare(strict_types=1);

namespace App\Documentation\Application\Output\Page;

use App\Documentation\Domain\PageType;

enum PageTypeOutput
{
    case Document;
    case Link;
    case Unknown;

    public static function fromPageType(PageType $type): self
    {
        return match ($type) {
            PageType::Document => self::Document,
            PageType::Link => self::Link,
            default => self::Unknown,
        };
    }
}
