<?php
declare(strict_types=1);

namespace Lix;

use Lix\Http\ApiClient;
use Lix\Resources\Groups;
use Lix\Resources\Links;
use Lix\Resources\Profile;
use Psr\Http\Client\ClientInterface;
use GuzzleHttp\Client as GuzzleHttpClient;

final class Client
{
    private Profile   $profile;
    private Groups    $groups;
    private Links     $links;

    public function __construct(
        private readonly string          $apiKey,
        private readonly ClientInterface $httpClient = new GuzzleHttpClient(),
    ) {
        $apiClient = new ApiClient($this->httpClient, $this->apiKey);

        $this->profile = new Profile($apiClient);
        $this->groups  = new Groups($apiClient);
        $this->links   = new Links($apiClient);
    }

    public function profile(): Profile
    {
        return $this->profile;
    }

    public function groups(): Groups
    {
        return $this->groups;
    }

    public function links(): Links
    {
        return $this->links;
    }
}
