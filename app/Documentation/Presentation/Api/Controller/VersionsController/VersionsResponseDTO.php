<?php

declare(strict_types=1);

namespace App\Documentation\Presentation\Api\Controller\VersionsController;

use App\Documentation\Presentation\Api\Response\DTO\VersionResponseDTO;
use TypeLang\Mapper\Mapping\MapType;

final readonly class VersionsResponseDTO
{
    /**
     * @var list<VersionResponseDTO>
     */
    #[MapType('list<VersionResponseDTO>')]
    public array $stable;

    /**
     * @var list<VersionResponseDTO>
     */
    #[MapType('list<VersionResponseDTO>')]
    public array $dev;

    /**
     * @var list<VersionResponseDTO>
     */
    #[MapType('list<VersionResponseDTO>')]
    public array $deprecated;

    /**
     * @param iterable<mixed, VersionResponseDTO> $stable
     * @param iterable<mixed, VersionResponseDTO> $dev
     * @param iterable<mixed, VersionResponseDTO> $deprecated
     */
    public function __construct(
        public VersionResponseDTO $current,
        iterable $stable = [],
        iterable $dev = [],
        iterable $deprecated = [],
    ) {
        $this->stable = \iterator_to_array($stable, false);
        $this->dev = \iterator_to_array($dev, false);
        $this->deprecated = \iterator_to_array($deprecated, false);
    }
}
