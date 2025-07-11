<?php

declare(strict_types=1);

namespace App\Sync\Domain;

use App\Sync\Domain\Repository\ExternalDocumentByNameProviderInterface;
use App\Sync\Domain\Repository\ExternalDocumentReferencesListProviderInterface;

interface ExternalDocumentRepositoryInterface extends
    ExternalDocumentByNameProviderInterface,
    ExternalDocumentReferencesListProviderInterface {}
