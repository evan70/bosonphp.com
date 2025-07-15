<?php

declare(strict_types=1);

namespace App\Shared\Domain;

/**
 * @template T of object
 */
interface SlugGeneratorInterface
{
    /**
     * @param T $target
     *
     * @return non-empty-lowercase-string
     */
    public function generateSlug(object $target): string;
}
