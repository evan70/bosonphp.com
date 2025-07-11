<?php

declare(strict_types=1);

namespace App\Sync\Application\UseCase\SyncVersion;

/**
 * @phpstan-type NavigationArrayType list<array{
 *     title: non-empty-string,
 *     description?: non-empty-string,
 *     icon?: non-empty-string,
 *     hidden?: bool,
 *     pages?: list<non-empty-string>
 * }>
 */
final readonly class SyncVersionNavigation
{
    public function __construct(
        /**
         * @var non-empty-string
         */
        public string $hash,
        /**
         * @var NavigationArrayType
         */
        public array $categories,
    ) {}
}
