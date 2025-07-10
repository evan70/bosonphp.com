<?php

declare(strict_types=1);

namespace App\Sync\Infrastructure\Downloader;

use App\Sync\Domain\DownloaderInterface;
use Github\Client as GitHubClient;

final readonly class GitHubDownloader implements DownloaderInterface
{
    public function __construct(
        GitHubClient $c,
    ) {
        dd(
            $c
        );
    }


}
