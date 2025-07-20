<?php

declare(strict_types=1);

namespace App\Tests\Context\Http;

use App\Tests\Context\SymfonyContext;
use Behat\Step\Then;
use Symfony\Component\HttpFoundation\Response;

/**
 * @api
 * @see http://behat.org/en/latest/quick_start.html
 */
final class ResponseTypeContext extends SymfonyContext
{
    /**
     * @api
     */
    #[Then('response is successful')]
    public function thenResponseIsSuccessful(): void
    {
        $responses = $this->context(ResponseContext::class);

        $responses->assertResponseIs(
            type: 'successful',
            handler: static fn(Response $response): bool => $response->isSuccessful(),
        );
    }

    /**
     * @api
     */
    #[Then('response is redirect')]
    public function thenResponseIsRedirect(): void
    {
        $responses = $this->context(ResponseContext::class);

        $responses->assertResponseIs(
            type: 'redirect',
            handler: static fn(Response $response): bool => $response->isRedirect(),
        );
    }

    /**
     * @api
     */
    #[Then('response is cacheable')]
    public function thenResponseIsCacheable(): void
    {
        $responses = $this->context(ResponseContext::class);

        $responses->assertResponseIs(
            type: 'cacheable',
            handler: static fn(Response $response): bool => $response->isCacheable(),
        );
    }

    /**
     * @api
     */
    #[Then('response is client error')]
    public function thenResponseIsClientError(): void
    {
        $responses = $this->context(ResponseContext::class);

        $responses->assertResponseIs(
            type: 'client error',
            handler: static fn(Response $response): bool => $response->isClientError(),
        );
    }

    /**
     * @api
     */
    #[Then('response is server error')]
    public function thenResponseIsServerError(): void
    {
        $responses = $this->context(ResponseContext::class);

        $responses->assertResponseIs(
            type: 'server error',
            handler: static fn(Response $response): bool => $response->isServerError(),
        );
    }

    /**
     * @api
     */
    #[Then('response is empty')]
    public function thenResponseIsEmpty(): void
    {
        $responses = $this->context(ResponseContext::class);

        $responses->assertResponseIs(
            type: 'empty',
            handler: static fn(Response $response): bool => $response->isEmpty(),
        );
    }

    /**
     * @api
     */
    #[Then('response is forbidden')]
    public function thenResponseIsForbidden(): void
    {
        $responses = $this->context(ResponseContext::class);

        $responses->assertResponseIs(
            type: 'forbidden',
            handler: static fn(Response $response): bool => $response->isForbidden(),
        );
    }

    /**
     * @api
     */
    #[Then('response is fresh')]
    public function thenResponseIsFresh(): void
    {
        $responses = $this->context(ResponseContext::class);

        $responses->assertResponseIs(
            type: 'fresh',
            handler: static fn(Response $response): bool => $response->isFresh(),
        );
    }

    /**
     * @api
     */
    #[Then('response is immutable')]
    public function thenResponseIsImmutable(): void
    {
        $responses = $this->context(ResponseContext::class);

        $responses->assertResponseIs(
            type: 'immutable',
            handler: static fn(Response $response): bool => $response->isImmutable(),
        );
    }

    /**
     * @api
     */
    #[Then('response is informational')]
    public function thenResponseIsInformational(): void
    {
        $responses = $this->context(ResponseContext::class);

        $responses->assertResponseIs(
            type: 'informational',
            handler: static fn(Response $response): bool => $response->isInformational(),
        );
    }

    /**
     * @api
     */
    #[Then('response is invalid')]
    public function thenResponseIsInvalid(): void
    {
        $responses = $this->context(ResponseContext::class);

        $responses->assertResponseIs(
            type: 'invalid',
            handler: static fn(Response $response): bool => $response->isInvalid(),
        );
    }

    /**
     * @api
     */
    #[Then('response is not found')]
    public function thenResponseIsNotFound(): void
    {
        $responses = $this->context(ResponseContext::class);

        $responses->assertResponseIs(
            type: 'not found',
            handler: static fn(Response $response): bool => $response->isNotFound(),
        );
    }

    /**
     * @api
     */
    #[Then('response is not modified')]
    public function thenResponseIsNotModified(): void
    {
        $responses = $this->context(ResponseContext::class);
        $requests = $this->context(RequestContext::class);

        $responses->assertResponseIs(
            type: 'not modified',
            handler: fn(Response $response): bool => $response->isNotModified(
                request: $requests->current,
            ),
        );
    }

    /**
     * @api
     */
    #[Then('response is json')]
    public function thenResponseIsJson(): void
    {
        $responses = $this->context(ResponseContext::class);

        $responses->assertResponseIs(
            type: 'json',
            handler: static fn(Response $response): bool
                => $response->headers->get('Content-Type') === 'application/json'
                    && \json_validate((string) $response->getContent()) !== false,
        );
    }
}
