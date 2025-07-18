<?php

declare(strict_types=1);

namespace App\Sync\Application\UseCase\GitHubWebhookValidate;

final readonly class GitHubWebhookValidateOutput
{
    public function __construct(
        public bool $isValid,
    ) {}
}
