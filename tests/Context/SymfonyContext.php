<?php

declare(strict_types=1);

namespace App\Tests\Context;

use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Hook\BeforeScenario;
use FriendsOfBehat\SymfonyExtension\Context\Environment\InitializedSymfonyExtensionEnvironment;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Output\StreamOutput;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\KernelInterface;

abstract class SymfonyContext implements Context
{
    protected ?InitializedSymfonyExtensionEnvironment $env = null;

    protected Application $app {
        get => $this->app ??= new Application($this->kernel);
    }

    protected ContainerInterface $container {
        get => $this->container ??= $this->kernel->getContainer();
    }

    public function __construct(
        protected readonly KernelInterface $kernel,
    ) {}

    /**
     * @api
     */
    #[BeforeScenario]
    public function gatherEnvironment(BeforeScenarioScope $scope): void
    {
        $environment = $scope->getEnvironment();

        if (!$environment instanceof InitializedSymfonyExtensionEnvironment) {
            throw new \LogicException('Unsupported tests environment');
        }

        $this->env = $environment;
    }

    protected function console(string $command): CommandTester
    {
        return new CommandTester($this->app->find($command));
    }

    protected function getConsoleOutput(CommandTester $tester): string
    {
        $output = $tester->getOutput();

        if ($output instanceof StreamOutput) {
            $stream = $output->getStream();

            \rewind($stream);

            return \stream_get_contents($stream);
        }

        return '';
    }

    /**
     * @template T of Context
     *
     * @param class-string<T> $context
     *
     * @return T
     */
    protected function context(string $context): Context
    {
        if ($this->env === null) {
            throw new \LogicException('Uninitialized environment');
        }

        return $this->env->getContext($context);
    }

    /**
     * @template TObject of object
     *
     * @param class-string<TObject> $id
     *
     * @return TObject
     * @throws \Exception
     */
    protected function get(string $id): object
    {
        /** @var TObject */
        return $this->container->get($id);
    }

    protected function has(string $id): bool
    {
        return $this->container->has($id);
    }

    /**
     * @param non-empty-string $name
     *
     * @throws \Exception
     */
    protected function getParameter(string $name): mixed
    {
        return $this->container->getParameter($name);
    }

    /**
     * @param non-empty-string $name
     *
     * @throws \Exception
     */
    protected function hasParameter(string $name): bool
    {
        return $this->container->hasParameter($name);
    }
}
