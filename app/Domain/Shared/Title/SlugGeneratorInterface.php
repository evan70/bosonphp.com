<?php

declare(strict_types=1);

namespace App\Domain\Shared\Title;

/**
 * @template T  of object
 */
interface SlugGeneratorInterface
{
    /**
     * @param T $entity
     *
     * @return non-empty-lowercase-string
     */
    public function createSlug(object $entity): string;
}
