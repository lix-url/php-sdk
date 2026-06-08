<?php

namespace Lix\DTO;

final readonly class Link
{
    public function __construct(
        public int     $id,
        public string  $alias,
        public string  $url,
        public string  $shortUrl,
        public ?string  $title,
        public ?Group  $group,
        public array   $tags,
        public array   $meta,
        public bool    $isPublic,
        public string  $createdDatetime,
        public ?string  $activeBeforeDatetime,
        public ?string $deletedDatetime,
    ) { }
}
