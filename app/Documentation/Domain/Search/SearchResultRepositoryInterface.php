<?php

declare(strict_types=1);

namespace App\Documentation\Domain\Search;

use App\Documentation\Domain\Search\Repository\SearchByOccurrenceProviderInterface;

interface SearchResultRepositoryInterface extends
    SearchByOccurrenceProviderInterface {}
