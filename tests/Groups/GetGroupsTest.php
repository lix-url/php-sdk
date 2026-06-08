<?php

declare(strict_types=1);


use GuzzleHttp\Psr7\Response;
use Lix\Tests\TestCase;

final class GetGroupsTest extends TestCase
{
    // Testing Groups DTO structure
    public function testGetGroupsDtoStructure(): void
    {
        $mockHttpClient = self::getHttpClient();
        $client = self::initClient();

        $mockHttpClient->addToResponseChain(new Response(200, [], '{"data":[{"id":1503,"alias":"demo","url":"https://lix.li/g/demo","name":"Seller group","is_rotate":false,"description":"Marketing group","created_datetime":"2026-05-21T22:08:37+03:00","deactivated_datetime":null}],"meta":{"total":1,"limit":20,"next_url":null}}'));

        $groupsResponse = $client->groups()->list();
        $this->assertCount(1, $groupsResponse->groups);

        $group = $groupsResponse->groups[0];


        $this->assertSame(1503, $group->id);
        $this->assertSame('Seller group', $group->name);
        $this->assertSame('Marketing group', $group->description);
        $this->assertSame('demo', $group->alias);
        $this->assertSame('https://lix.li/g/demo', $group->url);
        $this->assertSame(false, $group->isRotate);
        $this->assertSame(null, $group->deactivatedDatetime);
        $this->assertSame('2026-05-21T22:08:37+03:00', $group->createdDatetime);

        $this->assertSame(20, $groupsResponse->meta->limit);
        $this->assertSame(1, $groupsResponse->meta->total);
        $this->assertSame(null, $groupsResponse->meta->nextUrl);
    }

    // Testing get Groups with some result items and pagination
    public function testGetGroupsWithPagination(): void
    {
        $mockHttpClient = self::getHttpClient();
        $client = self::initClient();

        $mockHttpClient->addToResponseChain(new Response(200, [], '{"data":[{"id":1503,"alias":"demo","url":"https://lix.li/g/demo","name":"Seller group","is_rotate":false,"description":"Marketing group","created_datetime":"2026-05-21T22:08:37+03:00","deactivated_datetime":null},{"id":1505,"alias":"demo2","url":"https://lix.li/g/demo2","name":"Seller group 2","is_rotate":true,"description":"Marketing group for Marketologs","created_datetime":"2026-03-21T22:08:37+03:00","deactivated_datetime":"2027-03-21T22:08:37+03:00"}],"meta":{"total":5,"limit":2,"next_url":"https://lix.local/api/1.0/groups?from_id=1505&limit=5"}}'));

        $groupsResponse = $client->groups()->list();

        $this->assertCount(2, $groupsResponse->groups);

        $group = $groupsResponse->groups[0];
        $this->assertSame(1503, $group->id);
        $this->assertSame('Seller group', $group->name);
        $this->assertSame('Marketing group', $group->description);
        $this->assertSame('demo', $group->alias);
        $this->assertSame('https://lix.li/g/demo', $group->url);
        $this->assertSame(false, $group->isRotate);
        $this->assertSame(null, $group->deactivatedDatetime);
        $this->assertSame('2026-05-21T22:08:37+03:00', $group->createdDatetime);

        $group = $groupsResponse->groups[1];
        $this->assertSame(1505, $group->id);
        $this->assertSame('Seller group 2', $group->name);
        $this->assertSame('Marketing group for Marketologs', $group->description);
        $this->assertSame('demo2', $group->alias);
        $this->assertSame('https://lix.li/g/demo2', $group->url);
        $this->assertSame(true, $group->isRotate);
        $this->assertSame('2027-03-21T22:08:37+03:00', $group->deactivatedDatetime);
        $this->assertSame('2026-03-21T22:08:37+03:00', $group->createdDatetime);

        $this->assertSame(2, $groupsResponse->meta->limit);
        $this->assertSame(5, $groupsResponse->meta->total);
        $this->assertSame('https://lix.local/api/1.0/groups?from_id=1505&limit=5', $groupsResponse->meta->nextUrl);
    }

    // Testing the get groups list request structure
    public function testRequestGetGroupsWithoutQuery(): void
    {
        $mockHttpClient = self::getHttpClient();
        $client = self::initClient('lix_test_some_key1');

        $mockHttpClient->addToResponseChain(new Response(200, [], '{"data":[{"id":1503,"alias":"demo","url":"https://lix.li/g/demo","name":"Seller group","is_rotate":false,"description":"Marketing group","created_datetime":"2026-05-21T22:08:37+03:00","deactivated_datetime":null}],"meta":{"total":1,"limit":20,"next_url":null}}'));

        $client->groups()->list();

        $requests = $mockHttpClient->getRequests();
        $this->assertCount(1, $requests);

        $this->assertSame('https://lix.li/api/1.0/groups', (string) $requests[0]->getUri());
        $this->assertSame('[]', $requests[0]->getBody()->getContents());
        $this->assertSame('GET', $requests[0]->getMethod());
        $this->assertSame('lix_test_some_key1', $requests[0]->getHeaderLine('X-Api-key'));
        $this->assertSame('lix-php-sdk/0.1.0', $requests[0]->getHeaderLine('User-Agent'));
    }

    // Testing the get groups list request structure with query params
    public function testRequestGetGroupsWithQuery(): void
    {
        $mockHttpClient = self::getHttpClient();
        $client = self::initClient('lix_test_some_key1');

        $mockHttpClient->addToResponseChain(new Response(200, [], '{"data":[{"id":1503,"alias":"demo","url":"https://lix.li/g/demo","name":"Seller group","is_rotate":false,"description":"Marketing group","created_datetime":"2026-05-21T22:08:37+03:00","deactivated_datetime":null}],"meta":{"total":1,"limit":20,"next_url":null}}'));

        $client->groups()->list(100, 1500);

        $requests = $mockHttpClient->getRequests();
        $this->assertCount(1, $requests);

        $this->assertSame('https://lix.li/api/1.0/groups?limit=100&from_id=1500', (string) $requests[0]->getUri());
        $this->assertSame('[]', $requests[0]->getBody()->getContents());
        $this->assertSame('GET', $requests[0]->getMethod());
        $this->assertSame('lix_test_some_key1', $requests[0]->getHeaderLine('X-Api-key'));
        $this->assertSame('lix-php-sdk/0.1.0', $requests[0]->getHeaderLine('User-Agent'));
    }
}
