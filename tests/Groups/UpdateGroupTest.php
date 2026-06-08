<?php

declare(strict_types=1);


use GuzzleHttp\Psr7\Response;
use Lix\Tests\TestCase;

final class UpdateGroupTest extends TestCase
{
    // Testing Group DTO structure after update
    public function testGetGroup(): void
    {
        $mockHttpClient = self::getHttpClient();
        $client = self::initClient();

        $mockHttpClient->addToResponseChain(new Response(200, [], '{"data":{"id":1503,"alias":"demo","url":"https://lix.li/g/demo","name":"Seller group","is_rotate":false,"description":"Marketing group","created_datetime":"2026-05-21T22:08:37+03:00","deactivated_datetime":null}}'));

        $group = $client->groups()->update(
            1503,
            'Seller group',
            'Marketing group',
            true
        );

        $this->assertSame(1503, $group->id);
        $this->assertSame('Seller group', $group->name);
        $this->assertSame('Marketing group', $group->description);
        $this->assertSame('demo', $group->alias);
        $this->assertSame('https://lix.li/g/demo', $group->url);
        $this->assertSame(false, $group->isRotate);
        $this->assertSame(null, $group->deactivatedDatetime);
        $this->assertSame('2026-05-21T22:08:37+03:00', $group->createdDatetime);
    }

    // Testing the update group request structure
    public function testRequestCreateGroup(): void
    {
        $mockHttpClient = self::getHttpClient();
        $client = self::initClient('lix_test_some_key1');

        $mockHttpClient->addToResponseChain(new Response(200, [], '{"data":{"id":1503,"alias":"demo","url":"https://lix.li/g/demo","name":"Seller group","is_rotate":false,"description":"Marketing group","created_datetime":"2026-05-21T22:08:37+03:00","deactivated_datetime":null}}'));

        $client->groups()->update(
            1500,
            'Seller group',
            'Marketing group',
            true
        );

        $requests = $mockHttpClient->getRequests();
        $this->assertCount(1, $requests);

        $this->assertSame('https://lix.li/api/1.0/groups/1500', (string) $requests[0]->getUri());
        $this->assertSame('{"name":"Seller group","description":"Marketing group","is_rotate":true}', $requests[0]->getBody()->getContents());
        $this->assertSame('PATCH', $requests[0]->getMethod());
        $this->assertSame('lix_test_some_key1', $requests[0]->getHeaderLine('X-Api-key'));
        $this->assertSame('lix-php-sdk/0.1.0', $requests[0]->getHeaderLine('User-Agent'));
    }
}
