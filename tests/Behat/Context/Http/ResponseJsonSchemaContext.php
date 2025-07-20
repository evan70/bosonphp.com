<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\Http;

use App\Tests\Behat\Context\SymfonyContext;
use App\Tests\PHPUnit\Constraint\JsonSchemaMatches;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Hook\BeforeScenario;
use Behat\Step\Then;
use PHPUnit\Framework\Assert;

/**
 * @api
 *
 * @see http://behat.org/en/latest/quick_start.html
 */
final class ResponseJsonSchemaContext extends SymfonyContext
{
    private ?string $file = null;

    /**
     * @api
     */
    #[BeforeScenario]
    public function gatherFeature(BeforeScenarioScope $scope): void
    {
        $feature = $scope->getFeature();

        $this->file = $feature->getFile();
    }

    /**
     * @api
     *
     * @throws \JsonException
     */
    #[Then('response matches the schema:')]
    public function thenResponseMatchesTheSchema(PyStringNode $schema): self
    {
        $responses = $this->context(ResponseContext::class);

        Assert::assertThat($responses->content, new JsonSchemaMatches($schema->getRaw()));

        return $this;
    }

    /**
     * @api
     *
     * @throws \JsonException
     */
    #[Then('/^response matches the schema "(.+?)"$/')]
    public function thenResponseMatchesTheSchemaWith(string $schema): self
    {
        $responses = $this->context(ResponseContext::class);

        Assert::assertThat($responses->content, new JsonSchemaMatches($schema));

        return $this;
    }

    /**
     * @api
     *
     * @throws \JsonException
     */
    #[Then('/^response matches the schema file "(.+?)"$/')]
    public function thenResponseMatchesTheSchemaFile(string $schema): self
    {
        $responses = $this->context(ResponseContext::class);

        Assert::assertNotNull($this->file, 'Feature context is not set');

        $contents = \file_get_contents($pathname = \dirname($this->file) . '/' . $schema);

        Assert::assertNotFalse($contents, \sprintf('Schema file "%s" is not readable', $pathname));
        Assert::assertThat($responses->content, new JsonSchemaMatches($contents));

        return $this;
    }
}
