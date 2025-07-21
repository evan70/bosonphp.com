<?php

declare(strict_types=1);

namespace App\Documentation\Application\UseCase\UpdatePages\UpdatePagesIndexCommand;

use Symfony\Component\Validator\Constraints\NotBlank;

final readonly class LinkIndex extends PageIndex
{
    /**
     * @param non-empty-lowercase-string $hash
     */
    public function __construct(
        string $hash,
        /**
         * @var non-empty-string
         */
        #[NotBlank(allowNull: false)]
        public string $uri,
    ) {
        parent::__construct($hash);
    }
}
