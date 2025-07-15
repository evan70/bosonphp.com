<?php

declare(strict_types=1);

namespace App\Blog\Domain\Content;

use App\Shared\Domain\ContentRendererInterface;

/**
 * Defines contract for content renderers in the {@see ArticleContent} VO.
 *
 * @template-extends ContentRendererInterface<ArticleContent>
 */
interface ArticleContentRendererInterface extends
    ContentRendererInterface {}
