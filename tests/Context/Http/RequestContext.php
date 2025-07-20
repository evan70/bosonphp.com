<?php

declare(strict_types=1);

namespace App\Tests\Context\Http;

use App\Tests\Context\SymfonyContext;
use App\Tests\Extension\ContextArgumentTransformerExtension\AsTestingContext;
use Behat\Step\When;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[AsTestingContext('request')]
final class RequestContext extends SymfonyContext
{
    public Request $current {
        get {
            if ($this->history->isEmpty()) {
                return $this->prepareNextRequest();
            }

            /** @var Request */
            return $this->history->top();
        }
    }

    /**
     * @var \SplStack<Request>
     */
    public \SplStack $history {
        get => $this->history ??= new \SplStack();
    }

    #[When('/^(?:I )?send request$/')]
    public function send(): Response
    {
        $response = $this->kernel->handle($this->current);

        $this->prepareNextRequest();
        $this->pushNextResponse($response);

        return $response;
    }

    private function pushNextResponse(Response $response): void
    {
        $responses = $this->context(ResponseContext::class);
        $responses->history->push($response);
    }

    private function prepareNextRequest(): Request
    {
        $this->history->push($instance = Request::create('/'));

        return $instance;
    }
}
