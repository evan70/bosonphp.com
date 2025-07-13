<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus\EventBus;

use App\Shared\Domain\Id\UniversalUniqueId;

readonly class EventId extends UniversalUniqueId {}
