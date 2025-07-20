<?php

declare(strict_types=1);

namespace App\Tests\Context\Http;

use App\Tests\Context\SymfonyContext;
use App\Tests\Extension\ContextArgumentTransformerExtension\AsTestingContext;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Response;

#[AsTestingContext('response')]
final class ResponseContext extends SymfonyContext
{
    public Response $current {
        get {
            if ($this->history->isEmpty()) {
                $requests = $this->context(RequestContext::class);

                return $requests->send();
            }

            /** @var Response */
            return $this->history->top();
        }
    }

    /**
     * @var \SplStack<Response>
     */
    public \SplStack $history {
        get => $this->history ??= new \SplStack();
    }

    public string $assertResponseMessage {
        get => \sprintf('in response %s', $this->current->getContent() ?: '<empty>');
    }

    /**
     * @api
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
