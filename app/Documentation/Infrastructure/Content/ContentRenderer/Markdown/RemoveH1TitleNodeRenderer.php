<?php

declare(strict_types=1);

namespace App\Documentation\Infrastructure\Content\ContentRenderer\Markdown;

use League\CommonMark\Extension\CommonMark\Node\Block\Heading;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;

final class RemoveH1TitleNodeRenderer implements NodeRendererInterface
{
    public function render(Node $node, ChildNodeRendererInterface $childRenderer): ?string
    {
        assert($node instanceof Heading);

        if ($node->getLevel() === 1) {
            return '';
        }

        return null;
    }
}
