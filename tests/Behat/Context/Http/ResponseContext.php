<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\Http;

use App\Tests\Behat\Context\SymfonyContext;
use App\Tests\Behat\Extension\ContextArgumentTransformerExtension\AsTestingContext;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Response;

/**
 * @api
 *
 * @see http://behat.org/en/latest/quick_start.html
 */
#[AsTestingContext('response')]
final class ResponseContext extends SymfonyContext
{
    /**
     * Gets current response
     */
    public Response $current {
        get {
            if ($this->history->isEmpty()) {
                $requests = $this->context(RequestContext::class);

                return $requests->whenSend();
            }

            /** @var Response */
            return $this->history->top();
        }
    }

    /**
     * Gets current response content
     */
    public string $content {
        get => (string) $this->current->getContent();
    }

    /**
     * @var \SplStack<Response>
     */
    public \SplStack $history {
        get => $this->history ??= new \SplStack();
    }

    public string $assertResponseMessage {
        /** @phpstan-ignore-next-line : Allow short ternary */
        get => \sprintf('in response %s', $this->content ?: '<empty>');
    }

    /**
     * @api
     *
     * @param callable(Response):bool $handler
     */
    public function assertResponseIs(string $type, callable $handler): void
    {
        $message = \vsprintf('Response must be %s, but that did not happen %s', [
            $type,
            $this->assertResponseMessage,
        ]);

        Assert::assertTrue($handler($this->current), $message);
    }
}
