<?php

declare(strict_types=1);

namespace App\Documentation\Application\UseCase\UpdatePages\UpdatePagesIndexCommand;

use Symfony\Component\Validator\Constraints\NotBlank;

abstract readonly class PageIndex
{
    public function __construct(
        /**
         * @var non-empty-lowercase-string
         */
        #[NotBlank(allowNull: false)]
        public string $hash,
        /**
         * @var int<0, max>|null
         */
        public ?int $order = null,
    ) {}
}
