<?php

namespace Lix\DTO;

final readonly class Usages
{
    public function __construct(
        public UsageItem $links,
        public UsageItem $apiLinks,
        public UsageItem $massLinks,
    ) { }
}
