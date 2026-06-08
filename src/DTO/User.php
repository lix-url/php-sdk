<?php

namespace Lix\DTO;

final readonly class User
{
    public function __construct(
        public string $name,
        public string $email,
        public string $createdDatetime,
    ) { }
}
