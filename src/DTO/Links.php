<?php

namespace Lix\DTO;

final readonly class Links
{
    /**
     * @param Link[] $links
     */
    public function __construct(
        public array        $links,
        public ResponseMeta $meta,
    ) { }
}
