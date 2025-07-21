<?php

declare(strict_types=1);

namespace App\Documentation\Application\UseCase\UpdatePages\UpdatePagesIndexCommand;

use Symfony\Component\Validator\Constraints\NotBlank;

final readonly class DocumentIndex extends PageIndex
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
        public string $path,
    ) {
        parent::__construct($hash);
    }
}
