<?php

declare(strict_types=1);

namespace App\Shared\Domain\Date;

use Doctrine\ORM\Mapping as ORM;

/**
 * @phpstan-require-implements CreatedDateProviderInterface
 *
 * @mixin CreatedDateProviderInterface
 */
trait CreatedDateProvider
{
    #[ORM\Column(name: 'created_at', type: 'datetimetz_immutable', nullable: false, options: [
        'default' => 'CURRENT_TIMESTAMP',
    ])]
    public protected(set) \DateTimeImmutable $createdAt {
        get {
            try {
                /** @throws \Error : PHPStan false-positive. May throw in case of unitialized */
                return $this->createdAt;
            } catch (\Error) {
                // @phpstan-ignore-next-line : PHPStan false-positive. This variable is NOT readonly
                return $this->createdAt = new \DateTimeImmutable();
            }
        }
    }
}
