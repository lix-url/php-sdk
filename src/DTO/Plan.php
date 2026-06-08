<?php

namespace Lix\DTO;

final readonly class Plan
{
    public function __construct(
        public int     $id,
        public string  $name,
        public string  $startDatetime,
        public ?string $endDatetime,
    ) {
    }
}
