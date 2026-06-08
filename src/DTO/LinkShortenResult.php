<?php

namespace Lix\DTO;

final readonly class LinkShortenResult
{
    public function __construct(
        public Link      $link,
        public UsageItem $usage,
    ) { }
}
