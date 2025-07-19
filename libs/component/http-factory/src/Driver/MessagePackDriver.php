<?php

declare(strict_types=1);

namespace Local\Component\HttpFactory\Driver;

use MessagePack\MessagePack;

final readonly class MessagePackDriver extends Driver
{
    /**
     * A constant containing valid content-types that are responsible
     * for the msgpack inside the response body.
     *
     * @var non-empty-list<non-empty-string>
     */
    private const array SUPPORTED_CONTENT_TYPES_MSGPACK = [
        'application/msgpack',
        'application/x-msgpack',
    ];

    /**
     * @return non-empty-list<non-empty-string>
     */
    protected function getSupportedContentTypes(): array
    {
        return self::SUPPORTED_CONTENT_TYPES_MSGPACK;
    }

    protected function isAvailable(): bool
    {
        return \class_exists(MessagePack::class);
    }

    protected function fromString(string $data): mixed
    {
        try {
            return MessagePack::unpack($data);
        } catch (\Throwable $e) {
            $message = 'An error occurred while parsing request msgpack payload: ' . $e->getMessage();
            throw new \InvalidArgumentException($message, (int) $e->getCode());
        }
    }

    protected function toString(mixed $data): string
    {
        return MessagePack::pack($data);
    }
}
