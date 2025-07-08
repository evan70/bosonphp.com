<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Listener\Documentation;

use App\Domain\Documentation\Page;
use App\Domain\Documentation\PageDocument;
use App\Domain\Documentation\PageDocumentContent;
use App\Domain\Documentation\PageDocumentContentRendererInterface;
use App\Domain\Documentation\PageSlugGeneratorInterface;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;

/**
 * @api
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
