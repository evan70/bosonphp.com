<?php

declare(strict_types=1);

namespace App\Tests\Context\Http;

use App\Tests\Context\SymfonyContext;
use App\Tests\Extension\ContextArgumentTransformerExtension\AsTestingContext;
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
}
