<?php

namespace Lix\DTO;

final readonly class ResponseMeta
{
    public function __construct(
        public int     $total,
        public int     $limit,
        public ?string $nextUrl,
    ) { }
}
