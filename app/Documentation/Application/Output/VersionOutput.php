<?php

namespace App\Documentation\Application\Output;

use App\Documentation\Domain\Version\Version;

final readonly class VersionOutput
{
    public function __construct(
        /**
         * @var non-empty-string
         */
        public string $name,
        public VersionStatus $status,
    ) {}

    public function isStable(): bool
    {
        return $this->status === VersionStatus::Stable;
    }

    public function isDeprecated(): bool
    {
        return $this->status === VersionStatus::Deprecated;
    }

    public function isDev(): bool
    {
        return $this->status === VersionStatus::Dev;
    }

    public static function fromVersion(Version $version): self
    {
        return new self(
            name: $version->name,
            status: VersionStatus::fromStatus(
                status: $version->status,
            ),
        );
    }
}
