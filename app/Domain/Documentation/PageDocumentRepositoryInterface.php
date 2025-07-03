<?php

declare(strict_types=1);

namespace App\Domain\Documentation;

use Doctrine\Persistence\ObjectRepository;

/**
 * @template-extends ObjectRepository<Page>
 */
interface PageDocumentRepositoryInterface extends
    ObjectRepository {}
