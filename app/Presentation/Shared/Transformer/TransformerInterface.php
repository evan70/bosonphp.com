<?php

declare(strict_types=1);

namespace App\Presentation\Shared\Transformer;

/**
 * @template TInput of mixed = mixed
 * @template-covariant TOutput of mixed = mixed
 */
interface TransformerInterface
{
    /**
     * @param TInput $entry
     *
     * @return TOutput
     */
    public function transform(mixed $entry): mixed;
}
