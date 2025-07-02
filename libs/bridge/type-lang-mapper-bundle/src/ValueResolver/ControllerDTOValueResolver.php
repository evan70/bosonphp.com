<?php

declare(strict_types=1);

namespace Local\Bridge\TypeLang\ValueResolver;

use Local\Bridge\TypeLang\Attribute\MapRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use TypeLang\Mapper\DenormalizerInterface;

final readonly class ControllerDTOValueResolver implements ValueResolverInterface
{
    public function __construct(
        private DenormalizerInterface $denormalizer,
    ) {}

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

    private function create(Request $request, ArgumentMetadata $argument): mixed
    {
        //
        // 1. Lookup for #[MapRequest] attribute
        //

        $attribute = $this->findAttribute($argument);

        if (!$attribute instanceof MapRequest) {
            return null;
        }

        $body = $request->attributes->get('_body');

        if ($body === null) {
            return null;
        }

        try {
            /** @var class-string $type */
            $type = $attribute->as ?? $argument->getType() ?? 'object';

            return $this->denormalizer->denormalize($body, $type);
        } catch (HttpException $e) {
            throw $e;
        } catch (\Throwable $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
    }
}
