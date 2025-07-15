<?php

declare(strict_types=1);

namespace App\Shared\Domain;

/**
 * Defines contract for content preview generators.
 *
 * @template T of object
 */
interface ContentPreviewGeneratorInterface
{
    /**
     * @param T $target
     */
    public function generatePreview(object $target): string;
}
