<?php

declare(strict_types=1);

namespace App\Documentation\Infrastructure\Persistence\Doctrine\Listener;

use App\Documentation\Domain\Page;
use App\Documentation\Domain\PageDocument;
use App\Documentation\Domain\PageDocumentContent;
use App\Documentation\Domain\PageDocumentContentRendererInterface;
use App\Documentation\Domain\PageSlugGeneratorInterface;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;

/**
 * @api
 *
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal App\Documentation\Infrastructure\Persistence\Doctrine\Listener
 */
#[AsEntityListener(event: Events::postLoad, entity: Page::class)]
final readonly class PageLoadListener
{
    public function __construct(
        private PageDocumentContentRendererInterface $contentRenderer,
        private PageSlugGeneratorInterface $slugGenerator,
    ) {}

    /**
     * @api
     *
     * @throws \ReflectionException
     */
    public function postLoad(Page $page): void
    {
        if ($page instanceof PageDocument) {
            $this->bootSlugGenerator($page);
            $this->bootContentRenderer($page->content);
        }
    }

    /**
     * @throws \ReflectionException
     */
    private function bootContentRenderer(PageDocumentContent $content): void
    {
        $contentRenderer = new \ReflectionProperty($content, 'contentRenderer');

        if ($contentRenderer->isInitialized($content)) {
            return;
        }

        $contentRenderer->setValue($content, $this->contentRenderer);
    }

    /**
     * @throws \ReflectionException
     */
    private function bootSlugGenerator(Page $page): void
    {
        $slugGenerator = new \ReflectionProperty($page, 'slugGenerator');

        if ($slugGenerator->isInitialized($page)) {
            return;
        }

        $slugGenerator->setValue($page, $this->slugGenerator);
    }
}
