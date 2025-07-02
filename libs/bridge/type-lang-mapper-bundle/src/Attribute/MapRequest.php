<?php

declare(strict_types=1);

namespace Local\Bridge\TypeLang\Attribute;

#[\Attribute(\Attribute::TARGET_PARAMETER)]
final readonly class MapRequest
{
    public function __construct(
        /**
         * In the case that this parameter is not {@see null}, then the target
         * entry will be unpacked into an object of the specified class.
         *
         * This behavior can be useful if an interface is used as the
         * required type-hint:
         *
         * ```
         * public function exampleAction(
         *      #[MapRequest(as: ExampleValueObject::class)]
         *      ExampleValueObjectInterface $vo,
         * )
         * ```
         *
         * @var class-string|null
         */
        public ?string $as = null,
    ) {}
}
