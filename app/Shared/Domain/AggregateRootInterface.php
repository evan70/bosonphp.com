<?php

declare(strict_types=1);

namespace App\Shared\Domain;

use App\Shared\Domain\Id\IdentifiableInterface;

interface AggregateRootInterface extends
    IdentifiableInterface {}
