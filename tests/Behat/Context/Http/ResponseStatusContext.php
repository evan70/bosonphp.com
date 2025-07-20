<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\Http;

use App\Tests\Behat\Context\SymfonyContext;
use Behat\Gherkin\Node\TableNode;
use Behat\Step\Then;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Response;

/**
 * @api
 *
 * @see http://behat.org/en/latest/quick_start.html
 */
final class ResponseStatusContext extends SymfonyContext
{
    public int $statusCode {
        get => $this->context(ResponseContext::class)
            ->current->getStatusCode();
    }

    public string $assertResponseMessage {
        get => \vsprintf('%s %s', [
            $this->statusCode,
            $this->context(ResponseContext::class)->assertResponseMessage,
        ]);
    }

    /**
     * @api
     */
    public function assertResponseStatusIs(int $code): void
    {
        $message = \vsprintf('Response status-code must be %s, but received %s', [
            $code,
            $this->assertResponseMessage,
        ]);

        Assert::assertSame($code, $this->statusCode, $message);
    }

    /**
     * @api
     *
     * @param list<int> $codes
     */
    public function assertResponseStatusOneOf(array $codes): void
    {
        $message = \vsprintf('Response status-code must be one of %s, but received %s', [
            \implode(', ', $codes),
            $this->assertResponseMessage,
        ]);

        Assert::assertContains($this->statusCode, $codes, $message);
    }

    /**
     * @api
     */
    public function assertResponseStatusInRange(int $from, int $to): void
    {
        $message = \vsprintf('Response status-code must be %s, but received %s', [
            \sprintf('>=%d and <=%d', $from, $to),
            $this->assertResponseMessage,
        ]);

        Assert::assertGreaterThanOrEqual($from, $this->statusCode, $message);
        Assert::assertLessThanOrEqual($to, $this->statusCode, $message);
    }

    /**
     * @api
     */
    #[Then('/^response status is (\d+)/')]
    public function thenResponseStatusIs(int $expected): void
    {
        $this->assertResponseStatusIs($expected);
    }

    /**
     * @api
     */
    #[Then('response status is successful')]
    public function thenResponseIsSuccessful(): void
    {
        $this->thenResponseStatusInRange(200, 299);
    }

    /**
     * @api
     */
    #[Then('response status is client error')]
    public function thenResponseIsClientError(): void
    {
        $this->thenResponseStatusInRange(400, 499);
    }

    /**
     * @api
     */
    #[Then('response status is server error')]
    public function thenResponseIsServerError(): void
    {
        $this->thenResponseStatusInRange(500, 599);
    }

    /**
     * @api
     */
    #[Then('response status is ok')]
    public function thenResponseStatusIsOk(): void
    {
        $this->thenResponseStatusIs(Response::HTTP_OK);
    }

    /**
     * @api
     */
    #[Then('response status is unauthorized')]
    public function thenResponseStatusIsUnauthorized(): void
    {
        $this->thenResponseStatusIs(Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @api
     */
    #[Then('response status is bad request')]
    public function thenResponseStatusIsBadRequest(): void
    {
        $this->thenResponseStatusIs(Response::HTTP_BAD_REQUEST);
    }

    /**
     * @api
     */
    #[Then('response status is unprocessable')]
    public function thenResponseStatusIsUnprocessable(): void
    {
        $this->thenResponseStatusIs(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @api
     */
    #[Then('/^response status in (\d+?) to (\d+?) range$/')]
    public function thenResponseStatusInRange(int $from, int $to): void
    {
        $this->assertResponseStatusInRange($from, $to);
    }

    /**
     * @api
     */
    #[Then('response status one of:')]
    public function thenResponseStatusOneOf(TableNode $table): void
    {
        $codes = [];

        /** @var array{0?:scalar} $data */
        foreach ($table->getRows() as $data) {
            $codes[] = (int) ($data[0] ?? 0);
        }

        $this->assertResponseStatusOneOf($codes);
    }
}
