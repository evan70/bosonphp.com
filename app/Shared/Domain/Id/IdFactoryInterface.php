<?php

declare(strict_types=1);

namespace App\Shared\Domain\Id;

use App\Shared\Domain\Id\Exception\InvalidIdException;

/**
 * @template-covariant TOutput of IdInterface
 */
interface IdFactoryInterface
{
    /**
     * @return IdInterface
     * @throws InvalidIdException
     */
    public function create(mixed $input): IdInterface;
}
