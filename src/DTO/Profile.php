<?php

namespace Lix\DTO;

final readonly class Profile
{
    public function __construct(
        public Client $client,
        public User   $user,
        public Plan   $plan,
        public Usages $usages,
    ) { }
}
