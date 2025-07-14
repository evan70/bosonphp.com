<?php

declare(strict_types=1);

namespace App\Search\Domain;

use App\Search\Domain\Repository\SearchByOccurrenceProviderInterface;

interface SearchResultRepositoryInterface extends
    SearchByOccurrenceProviderInterface {}
