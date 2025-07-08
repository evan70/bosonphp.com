<?php

declare(strict_types=1);

namespace App\Shared\Domain\Id;

use App\Shared\Domain\Id\Exception\InvalidIdException;

/**
 * @template-covariant TOutput of IdInterface
 * @template-implements IdFactoryInterface<TOutput>
 */
abstract class UniversalUniqueIdFactory implements IdFactoryInterface
{
    /**
     * @var non-empty-string
     */
    public const string PATTERN = '/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/';

    /**
     * @param non-empty-string $value
     */
    abstract protected function createInstance(string $value): IdInterface;

    public function create(mixed $input): IdInterface
    {
        if (!\is_string($input)) {
            throw InvalidIdException::becauseTypeIsInvalid($input);
        }

        if ($input === '' || \preg_match(self::PATTERN, $input) !== 1) {
            throw InvalidIdException::becauseValueIsInvalid(
                expected: 'valid UUID',
                value: $input,
            );
        }

        return $this->createInstance($input);
    }
}
