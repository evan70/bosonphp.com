<?php

declare(strict_types=1);

namespace App\Tests\Behat\Extension\ContextArgumentTransformerExtension;

#[\Attribute(\Attribute::TARGET_CLASS)]
final readonly class AsTestingContext
{
    /**
     * @param non-empty-string $name
     */
    public function __construct(
        public string $name,
    ) {}
}
