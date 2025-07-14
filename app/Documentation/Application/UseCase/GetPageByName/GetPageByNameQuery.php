<?php

declare(strict_types=1);

namespace App\Documentation\Application\UseCase\GetPageByName;

use App\Shared\Domain\Bus\QueryId;
use Symfony\Component\Validator\Constraints\NotBlank;

final readonly class GetPageByNameQuery
{
    public function __construct(
        #[NotBlank(allowNull: false)]
        public string $name,
        #[NotBlank(allowNull: true)]
        public ?string $version = null,
        public QueryId $id = new QueryId(),
    ) {}
}
