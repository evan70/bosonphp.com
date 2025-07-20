<?php

declare(strict_types=1);

namespace App\Tests\Behat\Extension\ContextArgumentTransformerExtension;

use Behat\Behat\Definition\Call\DefinitionCall;
use Behat\Behat\Transformation\Transformer\ArgumentTransformer;
use FriendsOfBehat\SymfonyExtension\Context\Environment\InitializedSymfonyExtensionEnvironment;
use Symfony\Component\PropertyAccess\PropertyAccessorBuilder;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

/**
 * @api
 *
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal App\Tests\Behat\Extension
 */
final readonly class PlaceholderArgumentTransformer implements ArgumentTransformer
{
    private PropertyAccessorInterface $accessor;

    private EnvironmentSet $contexts;

    /**
     * @param non-empty-string $startsAt
     * @param non-empty-string $endsWith
     */
    public function __construct(
        private string $startsAt,
        private string $endsWith,
    ) {
        $this->contexts = new EnvironmentSet();
        $this->accessor = new PropertyAccessorBuilder()
            ->enableExceptionOnInvalidIndex()
            ->enableExceptionOnInvalidPropertyPath()
            ->getPropertyAccessor();
    }

    public function supportsDefinitionAndArgument(DefinitionCall $definitionCall, $argumentIndex, $argumentValue): bool
    {
        $environment = $definitionCall->getEnvironment();

        return $environment instanceof InitializedSymfonyExtensionEnvironment
            && \is_string($argumentValue)
            && \str_starts_with($argumentValue, $this->startsAt)
            && \str_ends_with($argumentValue, $this->endsWith);
    }

    private function getUnwrappedValue(string $value): string
    {
        return \trim(\substr(
            string: $value,
            offset: \strlen($this->startsAt),
            length: -\strlen($this->endsWith),
        ));
    }

    /**
     * @param int $argumentIndex
     * @param string $argumentValue
     */
    public function transformArgument(DefinitionCall $definitionCall, $argumentIndex, $argumentValue)
    {
        $unwrapped = $this->getUnwrappedValue($argumentValue);

        if ($unwrapped === '') {
            return $argumentValue;
        }

        /** @var InitializedSymfonyExtensionEnvironment $environment */
        $environment = $definitionCall->getEnvironment();

        return $this->accessor->getValue(
            objectOrArray: $this->contexts->get($environment),
            propertyPath: $unwrapped,
        );
    }
}
