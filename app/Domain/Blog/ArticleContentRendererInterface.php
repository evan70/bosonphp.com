<?php

declare(strict_types=1);

namespace App\Domain\Blog;

use App\Domain\Shared\Content\ContentRendererInterface;

/**
 * Defines contract for content renderers in the {@see Content} VO.
 *
 * @template-extends ContentRendererInterface<Content>
 */
interface ArticleContentRendererInterface extends
    ContentRendererInterface {}
