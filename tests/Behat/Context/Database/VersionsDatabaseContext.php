<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\Database;

use App\Documentation\Domain\Version\Status;
use App\Documentation\Domain\Version\Version;
use App\Tests\Behat\Context\SymfonyContext;
use App\Tests\Behat\Extension\ContextArgumentTransformerExtension\AsTestingContext;
use Behat\Step\Given;

/**
 * @api
 *
 * @see http://behat.org/en/latest/quick_start.html
 */
#[AsTestingContext('version')]
final class VersionsDatabaseContext extends SymfonyContext
{
    public ?Version $current {
        get {
            if ($this->history->isEmpty()) {
                return null;
            }

            /** @var Version */
            return $this->history->top();
        }
    }

    /**
     * @var \SplStack<Version>
     */
    public \SplStack $history {
        get => $this->history ??= new \SplStack();
    }

    public function given(Version $version): Version
    {
        $database = $this->context(DatabaseContext::class);

        $this->history->push($version);

        return $database->given($version);
    }

    /**
     * @api
     *
     * @param non-empty-string $version
     */
    #[Given('dev version :version')]
    public function givenDevVersion(string $version): void
    {
        $this->given(new Version($version, Status::Dev));
    }

    /**
     * @api
     *
     * @param non-empty-string $version
     */
    #[Given('stable version :version')]
    public function givenStableVersion(string $version): void
    {
        $this->given(new Version($version, Status::Stable));
    }

    /**
     * @api
     *
     * @param non-empty-string $version
     */
    #[Given('deprecated version :version')]
    public function givenDeprecatedVersion(string $version): void
    {
        $this->given(new Version($version, Status::Deprecated));
    }

    /**
     * @api
     *
     * @param non-empty-string $version
     */
    #[Given('hidden version :version')]
    public function givenHiddenVersion(string $version): void
    {
        $this->given(new Version($version, Status::Hidden));
    }
}
