<?php

declare(strict_types=1);

namespace App\Documentation\Application\Output;

use App\Documentation\Domain\Version\Version;
use App\Shared\Application\Output\CollectionOutput;

/**
 * @template-extends CollectionOutput<VersionOutput>
 */
final readonly class VersionsListOutput extends CollectionOutput
{
    /**
     * @var list<VersionOutput>
     */
    public array $dev;

    /**
     * @var list<VersionOutput>
     */
    public array $stable;

    /**
     * @var list<VersionOutput>
     */
    public array $deprecated;

    /**
     * @param iterable<mixed, VersionOutput> $versions
     */
    public function __construct(
        iterable $versions,
    ) {
        parent::__construct($versions);

        $this->dev = $this->only(VersionStatus::Dev);
        $this->stable = $this->only(VersionStatus::Stable);
        $this->deprecated = $this->only(VersionStatus::Deprecated);
    }

    /**
     * @return list<VersionOutput>
     */
    private function only(VersionStatus $status): array
    {
        $filter = static function (VersionOutput $v) use ($status): bool {
            return $v->status === $status;
        };

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
