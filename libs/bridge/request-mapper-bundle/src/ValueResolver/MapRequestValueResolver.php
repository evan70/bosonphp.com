<?php

declare(strict_types=1);

namespace Local\Bridge\RequestMapper\ValueResolver;

use Local\Bridge\RequestMapper\Attribute\MapRequest;
use Local\Component\HttpFactory\RequestDecoderFactoryInterface;
use Local\Component\HttpFactory\RequestDecoderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use TypeLang\Mapper\DenormalizerInterface;

final readonly class MapRequestValueResolver implements ValueResolverInterface
{
    public function __construct(
        private DenormalizerInterface $denormalizer,
        private RequestDecoderFactoryInterface $factory,
        private RequestDecoderInterface $default,
    ) {}

    /**
     * @return iterable<array-key, mixed>
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $payload = $this->create($request, $argument);

        if ($payload !== null) {
            yield $payload;
        }
    }

    private function findAttribute(ArgumentMetadata $argument): ?MapRequest
    {
        foreach ($argument->getAttributes(MapRequest::class, ArgumentMetadata::IS_INSTANCEOF) as $attribute) {
            /** @var MapRequest */
            return $attribute;
        }

        return null;
    }

    private function decode(Request $request): mixed
    {
        $decoder = $this->factory->createDecoder($request)
            ?? $this->default;

        try {
            return $decoder->decode($request->getContent());
        } catch (\Throwable $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
    }

    /**
     * @param non-empty-string $type
     */
    private function marshal(string $type, mixed $body): mixed
    {
        try {
            return $this->denormalizer->denormalize($body, $type);
        } catch (HttpException $e) {
            throw $e;
        } catch (\Throwable $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
    }

    private function create(Request $request, ArgumentMetadata $argument): mixed
    {
        $type = $this->findType($argument);

        if ($type === null) {
            return null;
        }

        return $this->marshal($type, $this->decode($request));
    }

    /**
     * @return non-empty-string|null
     */
    private function findType(ArgumentMetadata $argument): ?string
    {
        $attribute = $this->findAttribute($argument);

        if (!$attribute instanceof MapRequest) {
            return null;
        }

        if ($attribute->as !== null && $attribute->as !== '') {
            return $attribute->as;
        }

        $hint = $argument->getType();

        if ($hint !== null && $hint !== '') {
            return $hint;
        }

        return 'object';
    }
}
