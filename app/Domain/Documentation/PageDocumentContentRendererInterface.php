<?php

declare(strict_types=1);

namespace App\Domain\Documentation;

use App\Domain\Shared\Content\ContentRendererInterface;

/**
 * Defines contract for content renderers in the {@see ArticleContent} VO.
 *
 * @template-extends ContentRendererInterface<Content>
 */
interface PageDocumentContentRendererInterface extends
    ContentRendererInterface {}
