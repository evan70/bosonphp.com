<?php

declare(strict_types=1);

namespace App\Sync\Application\UseCase\GitHubWebhookValidate;

final readonly class GitHubWebhookValidateQuery
{
    public function __construct(
        /**
         * @var array<array-key, list<string|null>>
         */
        public array $headers,
        public string $body,
    ) {}
}
