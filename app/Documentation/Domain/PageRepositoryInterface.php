<?php

declare(strict_types=1);

namespace App\Documentation\Domain;

use App\Documentation\Domain\Repository\PageByNameProviderInterface;
use Doctrine\Persistence\ObjectRepository;

/**
 * @template-extends ObjectRepository<Document>
 */
interface PageRepositoryInterface extends
    PageByNameProviderInterface,
    ObjectRepository {}
