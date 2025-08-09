<?php

declare(strict_types=1);

namespace App\Documentation\Infrastructure\Content\ContentRenderer\Language;

use Tempest\Highlight\Languages\Json\JsonLanguage;
use Tempest\Highlight\Languages\Php\Patterns\SinglelineCommentPattern;

class Json5Language extends JsonLanguage
{
    public function getName(): string
    {
        return 'json5';
    }

    public function getPatterns(): array
    {
        return [
            ...parent::getPatterns(),
            new SinglelineCommentPattern(),
        ];
    }

    public function getAliases(): array
    {
        return ['json5'];
    }
}
