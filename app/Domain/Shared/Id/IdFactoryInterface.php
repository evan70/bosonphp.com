<?php

declare(strict_types=1);

namespace App\Domain\Shared\Id;

use App\Domain\Shared\Id\Exception\InvalidIdException;

/**
 * @template-covariant TOutput of IdInterface
 */
interface IdFactoryInterface
{
    /**
     * @return TOutput
     * @throws InvalidIdException
     */
    public function create(mixed $input): IdInterface;
}
