<?php

declare(strict_types=1);

namespace App\Documentation\Domain\Content;

use App\Shared\Domain\ContentRendererInterface;

/**
 * Defines contract for content renderers in the {@see DocumentContent} VO.
 *
 * @template-extends ContentRendererInterface<DocumentContent>
 */
interface DocumentContentRendererInterface extends
    ContentRendererInterface {}
