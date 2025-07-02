<?php

declare(strict_types=1);

namespace App\Presentation\Shared\Transformer\Response;

use App\Presentation\Shared\Transformer\Transformer;

/**
 * @template TInput of mixed = mixed
 * @template-covariant TOutput of mixed = mixed
 * @template-extends Transformer<TInput, TOutput>
 */
abstract readonly class ResponseTransformer extends Transformer {}
