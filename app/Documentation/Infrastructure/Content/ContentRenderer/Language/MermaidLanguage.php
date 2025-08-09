<?php

declare(strict_types=1);

namespace App\Documentation\Infrastructure\Content\ContentRenderer\Language;

use Tempest\Highlight\Languages\Base\BaseLanguage;

class MermaidLanguage extends BaseLanguage
{
    public function getName(): string
    {
        return 'mermaid';
    }

    public function getInjections(): array
    {
        return [];
    }

    public function getPatterns(): array
    {
        return [];
    }

    public function getAliases(): array
    {
        return [
            'mermaid',
        ];
    }
}
