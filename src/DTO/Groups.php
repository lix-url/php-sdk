<?php

namespace Lix\DTO;

final readonly class Groups
{
    /**
     * @param Group[] $groups
     */
    public function __construct(
        public array        $groups,
        public ResponseMeta $meta,
    ) { }
}
