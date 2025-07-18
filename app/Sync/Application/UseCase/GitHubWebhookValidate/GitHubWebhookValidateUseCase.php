<?php

declare(strict_types=1);

namespace App\Sync\Application\UseCase\GitHubWebhookValidate;

use Compwright\XHubSignature\SignerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(bus: 'query.bus')]
final readonly class GitHubWebhookValidateUseCase
{
    public function __construct(
        /**
         * @var non-empty-string
         */
        private string $secret,
        private SignerInterface $signer,
    ) {}

    /**
     * @return non-empty-string|null
     */
    private function findHeaderValue(GitHubWebhookValidateQuery $query): ?string
    {
        $values = $query->headers[$this->signer->getHeaderName()] ?? [];

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

        return new GitHubWebhookValidateOutput(
            isValid: $this->signer->verify($header, $this->secret, $query->body),
        );
    }
}
