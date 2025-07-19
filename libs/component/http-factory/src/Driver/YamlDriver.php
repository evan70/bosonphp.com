<?php

declare(strict_types=1);

namespace Local\Component\HttpFactory\Driver;

use Symfony\Component\Yaml\Yaml;

final readonly class YamlDriver extends Driver
{
    /**
     * A constant containing valid acceptable content-types that are responsible
     * for the yaml inside the response body.
     *
     * @var non-empty-list<non-empty-string>
     */
    private const array SUPPORTED_CONTENT_TYPES_YAML = [
        'application/yaml',
        'application/yml',
        'application/x-yaml',
        'application/x-yml',
        'text/yaml',
        'text/yml',
        'text/x-yaml',
    ];

    /**
     * @return non-empty-list<non-empty-string>
     */
    protected function getSupportedContentTypes(): array
    {
        return self::SUPPORTED_CONTENT_TYPES_YAML;
    }

    protected function isAvailable(): bool
    {
        return \class_exists(Yaml::class);
    }

    protected function fromString(string $data): mixed
    {
        try {
            return Yaml::parse($data, Yaml::PARSE_EXCEPTION_ON_INVALID_TYPE);
        } catch (\Throwable $e) {
            $message = 'An error occurred while parsing request yaml payload: ' . $e->getMessage();
            throw new \InvalidArgumentException($message, (int) $e->getCode());
        }
    }

    protected function toString(mixed $data): string
    {
        /** @var string */
        return Yaml::dump($data, 4, 2);
    }
}
