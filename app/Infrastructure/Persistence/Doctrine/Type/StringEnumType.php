<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;

/**
 * @api
 *
 * @internal this is an internal library class, please do not use it in your code.
 * @psalm-internal App\Infrastructure\Persistence\Doctrine\Type
 */
abstract class StringEnumType extends Type
{
    /**
     * @return non-empty-string
     */
    public function getName(): string
    {
        return static::getEnumClass();
    }

    /**
     * @return class-string<\BackedEnum>
     */
    abstract protected static function getEnumClass(): string;

    /**
     * @psalm-suppress UnnecessaryVarAnnotation
     */
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        $class = static::getEnumClass();

        return \strtolower(\str_replace('\\', '_', $class));
    }

    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): ?string
    {
        /** @var non-empty-string|null */
        return match (true) {
            $value === null => null,
            \is_string($value) => $value,
            $value instanceof \BackedEnum => $value->value,
            default => throw ConversionException::conversionFailedInvalidType(
                $value,
                \get_debug_type($value),
                ['null', 'string', static::getEnumClass()],
            ),
        };
    }

    /**
     * @param non-empty-string|null $value
     *
     * @phpstan-ignore-next-line phpstan covariant suppression
     */
    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): ?\BackedEnum
    {
        if ($value === null) {
            return null;
        }

        $class = static::getEnumClass();

        return $class::tryFrom($value);
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
