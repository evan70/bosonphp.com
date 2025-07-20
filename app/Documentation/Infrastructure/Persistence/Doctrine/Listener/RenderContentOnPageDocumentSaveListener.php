<?php

declare(strict_types=1);

namespace App\Documentation\Infrastructure\Persistence\Doctrine\Listener;

use App\Documentation\Domain\Content\PageDocumentContentRendererInterface;
use App\Documentation\Domain\PageDocument;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;

/**
 * @api
 *
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal App\Documentation\Infrastructure\Listener
 */
#[AsEntityListener(event: Events::preUpdate, entity: PageDocument::class, priority: 256)]
#[AsEntityListener(event: Events::prePersist, entity: PageDocument::class, priority: 256)]
final readonly class RenderContentOnPageDocumentSaveListener
{
    public function __construct(
        private PageDocumentContentRendererInterface $renderer,
    ) {}

    /**
     * @api
     */
    public function prePersist(PageDocument $document): void
    {
        $document->content->render($this->renderer);
    }

    /**
     * @api
     */
    public function preUpdate(PageDocument $document, PreUpdateEventArgs $event): void
    {
        if (!$event->hasChangedField('content.value')) {
            return;
        }

        $document->content->render($this->renderer);
    }
}
