<?php

declare(strict_types=1);

namespace App\Shared\Domain\Bus;

use App\Shared\Domain\Id\UniversalUniqueId;

readonly class CommandId extends UniversalUniqueId {}
