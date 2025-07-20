<?php

declare(strict_types=1);

namespace App\Documentation\Presentation\Api\Response\DTO;

use App\Documentation\Application\Output\Version\VersionOutput;

final readonly class VersionResponseDTO
{
    public function __construct(
        /**
         * @var non-empty-string
         */
        public string $version,
    ) {}

    public static function fromVersionOutput(VersionOutput $output): self
    {
        return new self(
            version: $output->name,
        );
    }

    /**
     * @param iterable<mixed, VersionOutput> $outputList
     * @return iterable<array-key, self>
     */
    public static function fromVersionOutputList(iterable $outputList): iterable
    {
        foreach ($outputList as $output) {
            yield self::fromVersionOutput($output);
        }
    }
}
