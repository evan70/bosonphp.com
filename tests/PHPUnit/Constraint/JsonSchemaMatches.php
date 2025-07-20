<?php

declare(strict_types=1);

namespace App\Tests\PHPUnit\Constraint;

use JsonSchema\Validator;
use PHPUnit\Framework\Constraint\Constraint;

final class JsonSchemaMatches extends Constraint
{
    private readonly object $schema;

    /**
     * @throws \JsonException
     */
    public function __construct(string $schema)
    {
        if (!\class_exists(Validator::class)) {
            throw new \LogicException('Package "justinrainbow/json-schema" required');
        }

        $this->schema = $this->forceToObject($schema);
    }

    /**
     * VERY dirty hack to force a JSON document into an object.
     *
     * @throws \JsonException
     */
    private function forceToObject(mixed $json): object
    {
        if (!\is_string($json)) {
            $json = \json_encode($json, \JSON_THROW_ON_ERROR);
        }

        $result = \json_decode($json, false, 512, \JSON_THROW_ON_ERROR);

        if (\is_array($result)) {
            return (object) $result;
        }

        if (\is_object($result)) {
            return $result;
        }

        return (object) [$result];
    }

    /**
     * @throws \JsonException
     */
    private function validate(mixed $other): Validator
    {
        if (\is_string($other) || \is_array($other) || \is_object($other)) {
            $other = $this->forceToObject($other);
        }

        $validator = new Validator();
        $validator->validate($other, $this->schema);

        return $validator;
    }

    /**
     * @throws \JsonException
     */
    protected function matches(mixed $other): bool
    {
        $validator = $this->validate($other);

        return $validator->isValid();
    }

    /**
     * @throws \JsonException
     */
    protected function additionalFailureDescription(mixed $other): string
    {
        $validator = $this->validate($other);

        $messages = [];

        foreach ($validator->getErrors() as $error) {
            if (!\is_array($error)) {
                continue;
            }

            $messages[] = \vsprintf('[%s] %s', [
                isset($error['property']) && \is_string($error['property'])
                    ? $error['property']
                    : '<unknown-property>',
                isset($error['message']) && \is_string($error['message'])
                    ? $error['message']
                    : '<unknown-message>',
            ]);
        }

        return \implode("\n", $messages);
    }

    public function toString(): string
    {
        return 'matches JSON Schema';
    }
}
