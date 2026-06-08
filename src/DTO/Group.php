<?php

namespace Lix\DTO;

final readonly class Group
{
    public function __construct(
        public int     $id,
        public string  $alias,
        public string  $url,
        public string  $name,
        public bool    $isRotate,
        public string  $description,
        public string  $createdDatetime,
        public ?string $deactivatedDatetime,
    ) { }
}
