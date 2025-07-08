<?php

declare(strict_types=1);

namespace App\Documentation\Domain;

use App\Domain\Shared\Content\ContentRendererInterface;

/**
 * Defines contract for content renderers in the {@see PageDocumentContent} VO.
 *
 * @template-extends ContentRendererInterface<PageDocumentContent>
 */
interface PageDocumentContentRendererInterface extends
    ContentRendererInterface {}
