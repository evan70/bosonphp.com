<?php

declare(strict_types=1);

namespace App\Documentation\Application\UseCase\UpdatePages\UpdatePagesIndexCommand;

use Symfony\Component\Validator\Constraints\NotBlank;

final readonly class PageIndex
{
    public function __construct(
        /**
         * @var non-empty-lowercase-string
         */
        #[NotBlank]
        public string $hash,
        /**
         * @var non-empty-string
         */
        #[NotBlank]
        public string $name,
    ) {}
}
