<?php

declare(strict_types=1);

namespace App\Sync\Application\UseCase\GitHubWebhookValidate;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(bus: 'query.bus')]
final readonly class GitHubWebhookValidateUseCase
{
    public function __construct(
        /**
         * @var non-empty-string
         */
        private string $secret,
    ) {}

    /**
     * @return non-empty-string|null
     */
    private function findHeaderValue(GitHubWebhookValidateQuery $query): ?string
    {
        $values = $query->headers['x-hub-signature-256'] ?? [];

        foreach ($values as $value) {
            if (\is_string($value) && $value !== '') {
                return $value;
            }
        }

        return null;
    }

    public function __invoke(GitHubWebhookValidateQuery $query): GitHubWebhookValidateOutput
    {
        $header = $this->findHeaderValue($query);

        if ($header === null) {
            return new GitHubWebhookValidateOutput(isValid: false);
        }

        $hash = \hash_hmac('sha256', $query->body, $this->secret, true);

        return new GitHubWebhookValidateOutput(
            isValid: \hash_equals('sha256=' . $hash, $header),
        );
    }
}
