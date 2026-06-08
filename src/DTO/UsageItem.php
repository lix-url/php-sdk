<?php

namespace Lix\DTO;

final readonly class UsageItem
{
    public function __construct(
        public ?int $limit,
        public int  $used,
        public ?int $remaining,
    ) { }
}
