<?php

declare(strict_types=1);

namespace App\Blog\Domain\Content;

use App\Shared\Domain\ContentPreviewGeneratorInterface;

/**
 * Defines contract for content preview generators in the {@see ArticleContent} VO.
 *
 * @template-extends ContentPreviewGeneratorInterface<ArticleContent>
 */
interface ArticlePreviewGeneratorInterface extends
    ContentPreviewGeneratorInterface {}
