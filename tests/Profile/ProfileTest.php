<?php

declare(strict_types=1);

namespace Lix\tests\Profile;

use GuzzleHttp\Psr7\Response;
use Lix\Tests\TestCase;

final class ProfileTest extends TestCase
{
    // Testing Profile DTO structure
    public function testMe(): void
    {
        $mockHttpClient = self::getHttpClient();
        $client = self::initClient();

        $mockHttpClient->addToResponseChain(new Response(200, [], '{"client":{"id":1022,"name":"Test Client","email":"test@lix.li","created_datetime":"2022-04-24T17:38:42+03:00"},"user":{"name":"John Doe","email":"test_user@lix.li","created_datetime":"2023-04-14T17:38:42+03:00"},"plan":{"id":2,"name":"Pro","start_datetime":"2026-05-09T13:12:46+03:00","end_datetime":"2027-05-09T13:12:46+03:00"},"usage":{"links":{"limit":null,"used":1,"remaining":null},"api_links":{"limit":500,"used":100,"remaining":400},"mass_links":{"limit":100,"used":10,"remaining":90}}}'));

        $profile = $client->profile()->me();

        $this->assertSame(1022, $profile->client->id);
        $this->assertSame('Test Client', $profile->client->name);
        $this->assertSame('test@lix.li', $profile->client->email);
        $this->assertSame('2022-04-24T17:38:42+03:00', $profile->client->createdDatetime);

        $this->assertSame('John Doe', $profile->user->name);
        $this->assertSame('test_user@lix.li', $profile->user->email);
        $this->assertSame('2023-04-14T17:38:42+03:00', $profile->user->createdDatetime);

        $this->assertSame(2, $profile->plan->id);
        $this->assertSame('Pro', $profile->plan->name);
        $this->assertSame('2026-05-09T13:12:46+03:00', $profile->plan->startDatetime);
        $this->assertSame('2027-05-09T13:12:46+03:00', $profile->plan->endDatetime);

        $this->assertSame(null, $profile->usages->links->limit);
        $this->assertSame(1, $profile->usages->links->used);
        $this->assertSame(null, $profile->usages->links->remaining);

        $this->assertSame(500, $profile->usages->apiLinks->limit);
        $this->assertSame(100, $profile->usages->apiLinks->used);
        $this->assertSame(400, $profile->usages->apiLinks->remaining);

        $this->assertSame(100, $profile->usages->massLinks->limit);
        $this->assertSame(10, $profile->usages->massLinks->used);
        $this->assertSame(90, $profile->usages->massLinks->remaining);
    }

    // Testing the get profile request structure
    public function testRequestMe(): void
    {
        $mockHttpClient = self::getHttpClient();
        $client = self::initClient('lix_test_some_key1');

        $mockHttpClient->addToResponseChain(new Response(200, [], '{"client":{"id":1022,"name":"Test Client","email":"test@lix.li","created_datetime":"2022-04-24T17:38:42+03:00"},"user":{"name":"John Doe","email":"test_user@lix.li","created_datetime":"2023-04-14T17:38:42+03:00"},"plan":{"id":2,"name":"Pro","start_datetime":"2026-05-09T13:12:46+03:00","end_datetime":"2027-05-09T13:12:46+03:00"},"usage":{"links":{"limit":null,"used":1,"remaining":null},"api_links":{"limit":500,"used":100,"remaining":400},"mass_links":{"limit":100,"used":10,"remaining":90}}}'));

        $client->profile()->me();

        $requests = $mockHttpClient->getRequests();
        $this->assertCount(1, $requests);

        $this->assertSame('https://lix.li/api/1.0/me', (string) $requests[0]->getUri());
        $this->assertSame('[]', $requests[0]->getBody()->getContents());
        $this->assertSame('GET', $requests[0]->getMethod());
        $this->assertSame('lix_test_some_key1', $requests[0]->getHeaderLine('X-Api-key'));
        $this->assertSame('lix-php-sdk/0.1.0', $requests[0]->getHeaderLine('User-Agent'));
    }
}
