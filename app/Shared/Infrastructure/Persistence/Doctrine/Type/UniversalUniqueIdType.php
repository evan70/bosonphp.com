<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Persistence\Doctrine\Type;

use App\Shared\Domain\Id\UniversalUniqueId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;

/**
 * @api
 *
 * @template T of UniversalUniqueId
 */
abstract class UniversalUniqueIdType extends Type
{
    /**
     * @return non-empty-string
     */
    public function getName(): string
    {
        return static::getClass();
    }

    /**
     * @return class-string<T>
     */
    abstract protected static function getClass(): string;

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL(['length' => 36]);
    }

    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): ?string
    {
        if (\is_string($value) || $value instanceof \Stringable) {
            return (string) $value;
        }

        return null;
    }

    /**
     * @return T|null
     * @throws ConversionException
     */
    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): ?UniversalUniqueId
    {
        if ($value === null) {
            return null;
        }

        if (!\is_string($value) || $value === '') {
            throw ConversionException::conversionFailedInvalidType(
                $value,
                \get_debug_type($value),
                ['null', 'non-empty-string'],
            );
        }

        /** @var class-string<T> $class */
        $class = static::getClass();

        return new $class($value);
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
