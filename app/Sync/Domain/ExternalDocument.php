<?php

declare(strict_types=1);

namespace App\Sync\Domain;

final class ExternalDocument extends ExternalPage
{
    /**
     * @param non-empty-lowercase-string $hash
     */
    public function __construct(
        ExternalPageId $id,
        string $hash,
        /**
         * @var non-empty-string
         */
        public readonly string $path,
        public string|\Stringable $content {
            get {
                if ($this->content instanceof \Stringable) {
                    return $this->content = (string) $this->content;
                }

                return $this->content;
            }
        },
    ) {
        parent::__construct($id, $hash);
    }
}
