<?php

declare(strict_types=1);

namespace App\Documentation\Application\UseCase\UpdatePages\UpdatePagesIndexCommand;

use Symfony\Component\Validator\Constraints\NotBlank;

final readonly class DocumentIndex extends PageIndex
{
    /**
     * @param non-empty-lowercase-string $hash
     * @param int<0, max>|null $order
     */
    public function __construct(
        string $hash,
        /**
         * @var non-empty-string
         */
        #[NotBlank(allowNull: false)]
        public string $path,
        ?int $order = null,
    ) {
        parent::__construct($hash, $order);
    }
}
