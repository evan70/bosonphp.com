<?php

declare(strict_types=1);

namespace App\Tests\Context\Http;

use App\Tests\Context\SymfonyContext;
use App\Tests\Extension\ContextArgumentTransformerExtension\AsTestingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Step\Given;
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
     * Gets or sets current request content
     */
    public string $content {
        get => $this->current->getContent();
        set(string|\Stringable $content) {
            if ($this->current->getMethod() === 'GET') {
                $this->givenRequestMethod('POST');
            }

            new \ReflectionObject($this->current)
                ->getProperty('content')
                ->setValue($this->current, (string) $content);
        }
    }

    /**
     * @var \SplStack<Request>
     */
    public \SplStack $history {
        get => $this->history ??= new \SplStack();
    }

    /**
     * @api
     *
     * @param non-empty-string $uri
     */
    #[Given('request uri is :uri')]
    public function givenRequestUri(string $uri): void
    {
        $buffer = Request::create($uri);

        $this->current->server->set('REQUEST_URI', $buffer->server->get('REQUEST_URI'));
        $this->current->server->set('QUERY_STRING', $buffer->server->get('QUERY_STRING'));
        $this->current->server->set('HTTP_HOST', $buffer->server->get('HTTP_HOST'));
        $this->current->server->set('HTTPS', $buffer->server->get('HTTPS'));
        $this->current->server->set('SERVER_NAME', $buffer->server->get('SERVER_NAME'));
        $this->current->server->set('SERVER_PORT', $buffer->server->get('SERVER_PORT'));
        $this->current->server->set('PHP_AUTH_USER', $buffer->server->get('PHP_AUTH_USER'));
        $this->current->server->set('PHP_AUTH_PW', $buffer->server->get('PHP_AUTH_PW'));
        $this->current->server->set('PATH_INFO', $buffer->server->get('PATH_INFO'));
    }

    /**
     * @api
     *
     * @param non-empty-string $method
     */
    #[Given('request method is :method')]
    public function givenRequestMethod(string $method): void
    {
        $this->current->server->set('REQUEST_METHOD', \strtoupper($method));
    }

    /**
     * @api
     */
    #[Given('request body is:')]
    public function givenRequestBodyWith(PyStringNode $node): void
    {
        $this->content = $node->getRaw();
    }

    /**
     * @api
     */
    #[Given('/^request body is (.+?)$/')]
    public function givenRequestBodyWithContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * @api
     */
    #[Given('request is json')]
    public function givenJsonHeaders(): void
    {
        $this->current->headers->set('Content-Type', 'application/json');
        $this->current->headers->set('Accept', 'application/json');
    }

    /**
     * @api
     */
    #[Given('request is json with:')]
    public function givenJsonBodyWith(PyStringNode $node): void
    {
        $this->givenJsonHeaders();
        $this->givenRequestBodyWith($node);
    }

    /**
     * @api
     */
    #[Given('/^request is json with (.+?)$/')]
    public function givenJsonBodyWithContent(string $content): void
    {
        $this->givenJsonHeaders();
        $this->givenRequestBodyWithContent($content);
    }

    #[When('/^(?:I )?send request$/')]
    public function whenSend(): Response
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
