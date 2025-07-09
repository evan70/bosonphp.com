<?php

declare(strict_types=1);

namespace App\Documentation\Application\Output\Version;

use App\Documentation\Domain\Version\Version;
use App\Shared\Application\Output\CollectionOutput;

/**
 * @template-extends CollectionOutput<VersionOutput>
 */
final class VersionsListOutput extends CollectionOutput
{
    /**
     * @var list<VersionOutput>
     */
    public array $dev {
        get => $this->dev ??= $this->only(VersionStatusOutput::Dev);
    }

    /**
     * @var list<VersionOutput>
     */
    public array $stable {
        get => $this->stable ??= $this->only(VersionStatusOutput::Stable);
    }

    /**
     * @var list<VersionOutput>
     */
    public array $deprecated {
        get => $this->deprecated ??= $this->only(VersionStatusOutput::Deprecated);
    }

    /**
     * @return list<VersionOutput>
     */
    private function only(VersionStatusOutput $status): array
    {
        $filter = static function (VersionOutput $v) use ($status): bool {
            return $v->status === $status;
        };

        /** @phpstan-ignore-next-line PHPStan false-positive, $items is list<T> */
        return \array_values(\array_filter($this->items, $filter));
    }

    /**
     * @param iterable<mixed, Version> $versions
     */
    public static function fromVersions(iterable $versions): self
    {
        $mapped = [];

        foreach ($versions as $version) {
            $mapped[] = VersionOutput::fromVersion($version);
        }

        return new self($mapped);
    }
}
