<?php

declare(strict_types=1);

namespace App\Shared\Domain;

/**
 * Defines contract for content renderers.
 *
 * @template T of object
 */
interface ContentRendererInterface
{
    /**
     * Renders the provided entity content string.
     *
     * @param T $target
     *
     * @throws \Throwable in case of rendering error occurs
     */
    public function renderContent(object $target): string;
}
