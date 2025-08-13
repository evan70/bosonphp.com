<?php

declare(strict_types=1);

namespace App\Documentation\Infrastructure\Content\ContentRenderer\Markdown;

use League\CommonMark\Event\DocumentParsedEvent;
use League\CommonMark\Extension\CommonMark\Node\Inline\Link;
use Psr\Http\Message\UriFactoryInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final readonly class NormalizeInternalLinksProcessor
{
    public function __construct(
        private UriFactoryInterface $parser,
        private UrlGeneratorInterface $generator,
    ) {}

    public function __invoke(DocumentParsedEvent $e): void
    {
        foreach ($e->getDocument()->iterator() as $link) {
            if (!$link instanceof Link) {
                continue;
            }

            $this->process($link);
        }
    }

    private function process(Link $link): void
    {
        $uri = $this->parser->createUri($link->getUrl());

        // In case of absolute URI
        if ($uri->getScheme() !== '') {
            return;
        }

        // In case of non-markdown URI
        if (!\str_ends_with($uri->getPath(), '.md')) {
            return;
        }

        // Remove md suffix
        $uri = $uri->withPath($this->generator->generate('doc.show', [
            'page' => \pathinfo($uri->getPath(), \PATHINFO_FILENAME),
            'version' => '%version%',
        ]));

        $link->setUrl((string) $uri);
    }
}
