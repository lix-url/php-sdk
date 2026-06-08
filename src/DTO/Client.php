<?php

namespace Lix\DTO;

final readonly class Client
{
    public function __construct(
        public int    $id,
        public string $name,
        public string $email,
        public string $createdDatetime,
    ) { }
}
