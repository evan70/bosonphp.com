<?php

declare(strict_types=1);

namespace App\Documentation\Infrastructure\Persistence\Doctrine\Listener;

use App\Documentation\Domain\Content\DocumentContentRendererInterface;
use App\Documentation\Domain\Document;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;

/**
 * @api
 *
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal App\Documentation\Infrastructure\Listener
 */
#[AsEntityListener(event: Events::preUpdate, entity: Document::class, priority: 256)]
#[AsEntityListener(event: Events::prePersist, entity: Document::class, priority: 256)]
final readonly class RenderContentOnDocumentSaveListener
{
    public function __construct(
        private DocumentContentRendererInterface $renderer,
    ) {}

    /**
     * @api
     */
    public function prePersist(Document $document): void
    {
        $document->content->render($this->renderer);
    }

    /**
     * @api
     */
    public function preUpdate(Document $document, PreUpdateEventArgs $event): void
    {
        // if (!$event->hasChangedField('content.value')) {
        //     return;
        // }

        $document->content->render($this->renderer);
    }
}
