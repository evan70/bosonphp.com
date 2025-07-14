<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Persistence\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;

final class TsVectorType extends Type
{
    public const string NAME = 'tsvector';

    public function getName(): string
    {
        return self::NAME;
    }

    public function canRequireSQLConversion(): bool
    {
        return true;
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getDoctrineTypeMapping(self::NAME);
    }

    /**
     * @return list<non-empty-string>
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): array
    {
        if (!\is_string($value) || $value === '') {
            return [];
        }

        $terms = [];

        foreach (\explode(' ', $value) as $item) {
            [$term] = \explode(':', $item);
            $term = \trim($term, '\'');

            if ($term !== '') {
                $terms[] = $term;
            }
        }

        return $terms;
    }

    public function convertToDatabaseValueSQL($sqlExpr, AbstractPlatform $platform): string
    {
        if (!\is_string($sqlExpr)) {
            throw ConversionException::conversionFailedInvalidType($sqlExpr, 'string', ['string']);
        }

        return \sprintf('to_tsvector(%s)', $sqlExpr);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        if (\is_array($value)) {
            $value = \implode(' ', $value);
        }

        if (!\is_string($value)) {
            throw ConversionException::conversionFailedInvalidType($value, 'string', ['string', 'list<string>']);
        }

        return $value;
    }
}
