<?php

declare(strict_types=1);

namespace App\Sync\Application\UseCase\GetExternalDocumentByName;

use App\Shared\Domain\Bus\QueryId;
use Symfony\Component\Validator\Constraints\NotBlank;

final readonly class GetExternalDocumentByNameQuery
{
    public function __construct(
        /**
         * @var non-empty-string
         */
        #[NotBlank(allowNull: false)]
        public string $version,
        /**
         * @var non-empty-string
         */
        #[NotBlank(allowNull: false)]
        public string $path,
        public QueryId $id = new QueryId(),
    ) {}
}
