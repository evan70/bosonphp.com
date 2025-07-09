<?php

declare(strict_types=1);

namespace App\Shared\Presentation\Api\Response;

use App\Shared\Presentation\Api\Transformer\Transformer;

/**
 * @template TInput of mixed = mixed
 * @template-covariant TOutput of mixed = mixed
 * @template-extends Transformer<TInput, TOutput>
 */
abstract readonly class ResponseTransformer extends Transformer {}
