<?php

declare(strict_types=1);

namespace App\Tests\Context\Support;

use App\Tests\Context\Http\ResponseContext;
use App\Tests\Context\SymfonyContext;
use Behat\Hook\BeforeScenario;
use Behat\Step\Then;
use Symfony\Component\VarDumper\VarDumper;

/**
 * @api
 * @see http://behat.org/en/latest/quick_start.html
 */
final class VarDumperContext extends SymfonyContext
{
    /**
     * @api
     */
    //#[BeforeScenario]
    public function setUpVarDumper(): void
    {
        $_SERVER['VAR_DUMPER_FORMAT'] = 'cli';
        $_SERVER['IDEA_INITIAL_DIRECTORY'] = __DIR__;
    }

    /**
     * @api
     */
    #[Then('/^dump "(?P<value>.+?)"$/')]
    public function thenDumpValue(mixed $value): void
    {
        VarDumper::dump($value);
    }

    /**
     * @api
     */
    #[Then('dump response')]
    public function thenDumpResponse(): void
    {
        $responses = $this->context(ResponseContext::class);

        VarDumper::dump($responses->current);
    }

    /**
     * @api
     */
    #[Then('dump response headers')]
    public function thenDumpResponseHeaders(): void
    {
        $responses = $this->context(ResponseContext::class);

        VarDumper::dump($responses->current->headers->all());
    }

    /**
     * @api
     */
    #[Then('dump response body')]
    public function thenDumpResponseBody(): void
    {
        $responses = $this->context(ResponseContext::class);

        VarDumper::dump($responses->current->getContent());
    }
}
