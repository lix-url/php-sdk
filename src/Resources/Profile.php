<?php

namespace Lix\Resources;

use Lix\DTO\Client;
use Lix\DTO\Plan;
use Lix\DTO\UsageItem;
use Lix\DTO\Usages;
use Lix\DTO\User;
use Lix\Http\ApiClient;
use Lix\DTO\Profile as ProfileDto;

final readonly class Profile
{
    public function __construct(private ApiClient $apiClient)
    { }

    public function me(): ProfileDto
    {
        $data = $this->apiClient->getProfileMe();

        return new ProfileDto(
            new Client(
                $data['client']['id'],
                $data['client']['name'],
                $data['client']['email'],
                $data['client']['created_datetime'],
            ),
            new User(
                $data['user']['name'],
                $data['user']['email'],
                $data['user']['created_datetime'],
            ),
            new Plan(
                $data['plan']['id'],
                $data['plan']['name'],
                $data['plan']['start_datetime'],
                $data['plan']['end_datetime'],
            ),
            new Usages(
                new UsageItem($data['usage']['links']['limit'], $data['usage']['links']['used'], $data['usage']['links']['remaining']),
                new UsageItem($data['usage']['api_links']['limit'], $data['usage']['api_links']['used'], $data['usage']['api_links']['remaining']),
                new UsageItem($data['usage']['mass_links']['limit'], $data['usage']['mass_links']['used'], $data['usage']['mass_links']['remaining']),
            ),
        );
    }
}
