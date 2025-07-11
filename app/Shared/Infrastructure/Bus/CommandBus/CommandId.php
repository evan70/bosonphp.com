<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus\CommandBus;

use App\Shared\Domain\Id\UniversalUniqueId;

readonly class CommandId extends UniversalUniqueId {}
