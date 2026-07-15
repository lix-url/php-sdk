<?php
declare(strict_types=1);

namespace Lix\Http;

use GuzzleHttp\Psr7\Request;
use Lix\Exceptions\ConflictException;
use Lix\Exceptions\NotFoundException;
use Lix\Exceptions\PlanLimitException;
use Lix\Exceptions\RateLimitException;
use Lix\Exceptions\ServerException;
use Lix\Exceptions\UnauthorizedException;
use Lix\Exceptions\UnprocessableEntity;
use Lix\Exceptions\ValidationException;
use Psr\Http\Client\ClientInterface;

final class ApiClient
{
    private const API_URL = 'https://lix.li/api/1.0';

    public function __construct(
        private ClientInterface $httpClient,
        private string          $apiKey,
    ) { }

    private function sendRequest(string $method, string $endpoint, array $postData = []): array
    {
        $response = $this->httpClient->sendRequest(new Request(
            $method,
            sprintf('%s/%s', self::API_URL, $endpoint),
            [
                'X-Api-Key'  => $this->apiKey,
                'Accept'     => 'application/json',
                'User-Agent' => 'lix-php-sdk/0.1.0',
            ],
            json_encode($postData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
        ));
        $responseContent = $response->getBody()->getContents();

        $data = $responseContent ? json_decode(
            $responseContent,
            true,
            512,
            JSON_THROW_ON_ERROR
        ) : [];
        switch ($response->getStatusCode()) {
            case 400:
                throw new ValidationException($data['parameter_errors']);
            case 401:
                throw new UnauthorizedException();
            case 404:
                throw new NotFoundException();
            case 409:
                throw new ConflictException($data['error_message'] ?? '');
            case 422:
                $errorName = $data['error'] ?? null;
                if ($errorName === 'plan_limit_exceeded') {
                    $e = new PlanLimitException($data['error_message'] ?? '');
                    $e->setErrorData($data);
                    throw $e;
                }
                throw new UnprocessableEntity($data['error_message'] ?? '');
            case 429:
                throw new RateLimitException();
            case 500:
                throw new ServerException();
        }

        return $data;
    }

    private function get(string $endpoint): array
    {
        return $this->sendRequest('GET', $endpoint);
    }

    private function delete(string $endpoint): array
    {
        return $this->sendRequest('DELETE', $endpoint);
    }

    private function patch(string $endpoint, array $data): array
    {
        return $this->sendRequest('PATCH', $endpoint, $data);
    }

    private function post(string $endpoint, array $data): array
    {
        return $this->sendRequest('POST', $endpoint, $data);
    }

    /**
     * Returns information about the authenticated client.
     * @see https://lix.li/api#/Profile/get_me
     */
    public function getProfileMe(): array
    {
        return $this->get('me');
    }

    /**
     * Returns a single group by ID.
     * @see https://lix.li/api#/Groups/get_groups__id_
     */
    public function getGroup(int $id): array
    {
        return $this->get(sprintf('groups/%d', $id));
    }

    /**
     * Returns a list of groups.
     * @see https://lix.li/api#/Groups/get_groups
     */
    public function getGroups(?int $limit = null, ?int $fromId = null): array
    {
        $query = [];

        if ($limit) {
            $query['limit'] = $limit;
        }

        if ($fromId) {
            $query['from_id'] = $fromId;
        }

        return $this->get(sprintf('groups?%s', http_build_query($query)));
    }

    /**
     * Delete a group by ID.
     * @see https://lix.li/api#/Groups/delete_groups__id_
     */
    public function deleteGroup(int $id): array
    {
        return $this->delete(sprintf('groups/%d', $id));
    }

    /**
     * Update an existing group.
     * @see https://lix.li/api#/Groups/patch_groups__id_
     */
    public function updateGroup(int $id, array $data): array
    {
        return $this->patch(sprintf('groups/%d', $id), $data);
    }

    /**
     * Create a new link group.
     * @see https://lix.li/api#/Groups/post_groups
     */
    public function createGroup(array $data): array
    {
        return $this->post('groups', $data);
    }

    /**
     * Returns a single link by ID.
     * @see https://lix.li/api#/Links/get_links__id_
     */
    public function getLink(int $id): array
    {
        return $this->get(sprintf('links/%d', $id));
    }

    /**
     * Returns a list of links.
     * @see https://lix.li/api#/Links/get_links
     */
    public function getLinks(?int $limit = null, ?int $fromId = null): array
    {
        $query = [];

        if ($limit) {
            $query['limit'] = $limit;
        }

        if ($fromId) {
            $query['from_id'] = $fromId;
        }

        return $this->get(sprintf('links?%s', http_build_query($query)));
    }

    /**
     * Delete a link by ID.
     * @see https://lix.li/api#/Links/delete_links__id_
     */
    public function deleteLink(int $id): array
    {
        return $this->delete(sprintf('links/%d', $id));
    }

    /**
     * Update an existing link.
     * @see https://lix.li/api#/Links/patch_links__id_
     */
    public function updateLink(int $id, array $data): array
    {
        return $this->patch(sprintf('links/%d', $id), $data);
    }

    /**
     * Create a new short link.
     * @see https://lix.li/api#/Links/post_links
     */
    public function createLink(array $data): array
    {
        return $this->post('links', $data);
    }
}
