<?php

declare(strict_types=1);

namespace App\Documentation\Application\UseCase\GetVersionByName;

use App\Shared\Domain\Bus\QueryId;
use Symfony\Component\Validator\Constraints\NotBlank;

final readonly class GetVersionByNameQuery
{
    public function __construct(
        #[NotBlank(allowNull: true)]
        public ?string $version = null,
        public QueryId $id = new QueryId(),
    ) {}
}
