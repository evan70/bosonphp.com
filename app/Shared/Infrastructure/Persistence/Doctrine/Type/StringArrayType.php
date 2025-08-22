<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Persistence\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

/**
 * @api
 *
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal App\Shared\Infrastructure\Persistence\Doctrine\Type
 */
class StringArrayType extends Type
{
    /**
     * @return non-empty-string
     */
    public function getName(): string
    {
        return 'string[]';
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getJsonTypeDeclarationSQL($column);
    }

    /**
     * @param list<string|null>|null $value
     *
     * @return non-empty-string|null
     *
     * @phpstan-ignore-next-line Method covariance failure
     */
    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): ?string
    {
        if ($value === null) {
            return null;
        }

        return json_encode($value);
    }

    /**
     * @param non-empty-string|null $value
     *
     * @return list<string|null>|null
     *
     * @phpstan-ignore-next-line Method covariance failure
     */
    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): ?array
    {
        if ($value === null) {
            return null;
        }

        return json_decode($value, true);
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
