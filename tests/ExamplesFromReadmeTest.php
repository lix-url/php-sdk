<?php

declare(strict_types=1);

namespace Lix\Tests;

use GuzzleHttp\Psr7\Response;

final class ExamplesFromReadmeTest extends TestCase
{
    // QuickStart example test
    public function testQuickStart(): void
    {
        $mockHttpClient = self::getHttpClient();
        $client         = self::initClient('lix_test_some_key1');

        $mockHttpClient->addToResponseChain(new Response(201, [], '{"data":{"id":79697,"alias":"demo2","short_url":"https://lix.li/demo2","url":"https://example.com","is_public":true,"title":null,"created_datetime":"2026-05-27T22:16:22+03:00","active_before_datetime":null,"deleted_datetime":null,"group":null,"tags":["sale","promo"],"meta":[]},"usage":{"limit":500,"used":3,"remaining":497}}'));

        $link = $client->links()->create('https://example.com');

        $requests = $mockHttpClient->getRequests();
        $this->assertCount(1, $requests);

        $this->assertSame('https://lix.li/api/1.0/links', (string)$requests[0]->getUri());
        $this->assertSame('{"group_id":null,"url":"https://example.com","alias":null,"password":null,"title":null,"tags":[],"is_public":true,"tracking_pixel_ids":[],"meta":[],"utm":[],"active_before_datetime":null}', $requests[0]->getBody()->getContents());
        $this->assertSame('POST', $requests[0]->getMethod());
        $this->assertSame('lix_test_some_key1', $requests[0]->getHeaderLine('X-Api-key'));
        $this->assertSame('lix-php-sdk/0.1.0', $requests[0]->getHeaderLine('User-Agent'));

        $this->assertSame('https://lix.li/demo2', $link->link->shortUrl);
        $this->assertSame('https://example.com', $link->link->url);
    }

    // Create link example test
    public function testCreateLink(): void
    {
        $mockHttpClient = self::getHttpClient();
        $client         = self::initClient('lix_test_some_key1');

        $mockHttpClient->addToResponseChain(new Response(201, [], '{"data":{"id":79697,"alias":"demo2","short_url":"https://lix.li/demo2","url":"https://example.com","is_public":true,"title":null,"created_datetime":"2026-05-27T22:16:22+03:00","active_before_datetime":null,"deleted_datetime":null,"group":null,"tags":["sale","promo"],"meta":[]},"usage":{"limit":500,"used":3,"remaining":497}}'));

        $link = $client->links()->create(
            url: 'https://example.com'
        );

        $requests = $mockHttpClient->getRequests();
        $this->assertCount(1, $requests);

        $this->assertSame('https://lix.li/api/1.0/links', (string)$requests[0]->getUri());
        $this->assertSame('{"group_id":null,"url":"https://example.com","alias":null,"password":null,"title":null,"tags":[],"is_public":true,"tracking_pixel_ids":[],"meta":[],"utm":[],"active_before_datetime":null}', $requests[0]->getBody()->getContents());
        $this->assertSame('POST', $requests[0]->getMethod());
        $this->assertSame('lix_test_some_key1', $requests[0]->getHeaderLine('X-Api-key'));
        $this->assertSame('lix-php-sdk/0.1.0', $requests[0]->getHeaderLine('User-Agent'));

        $this->assertSame('https://lix.li/demo2', $link->link->shortUrl);
        $this->assertSame('https://example.com', $link->link->url);
    }

    // Update link example test
    public function testUpdateLink(): void
    {
        $mockHttpClient = self::getHttpClient();
        $client         = self::initClient('lix_test_some_key1');

        $mockHttpClient->addToResponseChain(new Response(201, [], '{"data":{"id":79697,"alias":"demo2","short_url":"https://lix.li/demo2","url":"https://example.com","is_public":true,"title":null,"created_datetime":"2026-05-27T22:16:22+03:00","active_before_datetime":null,"deleted_datetime":null,"group":null,"tags":["sale","promo"],"meta":[]},"usage":{"limit":500,"used":3,"remaining":497}}'));

        $link = $client->links()->update(
            id: 123,
            title: 'Updated title'
        );

        $requests = $mockHttpClient->getRequests();
        $this->assertCount(1, $requests);

        $this->assertSame('https://lix.li/api/1.0/links/123', (string)$requests[0]->getUri());
        $this->assertSame('{"group_id":null,"url":null,"password":null,"title":"Updated title","tags":[],"is_public":true,"tracking_pixel_ids":[],"meta":[],"utm":[],"active_before_datetime":null}', $requests[0]->getBody()->getContents());
        $this->assertSame('PATCH', $requests[0]->getMethod());
        $this->assertSame('lix_test_some_key1', $requests[0]->getHeaderLine('X-Api-key'));
        $this->assertSame('lix-php-sdk/0.1.0', $requests[0]->getHeaderLine('User-Agent'));

        $this->assertSame('https://lix.li/demo2', $link->link->shortUrl);
        $this->assertSame('https://example.com', $link->link->url);
    }

    // Delete link example test
    public function testDeleteLink(): void
    {
        $mockHttpClient = self::getHttpClient();
        $client         = self::initClient('lix_test_some_key1');

        $mockHttpClient->addToResponseChain(new Response(201, [], '{"data":{"id":79697,"alias":"demo2","short_url":"https://lix.li/demo2","url":"https://example.com","is_public":true,"title":null,"created_datetime":"2026-05-27T22:16:22+03:00","active_before_datetime":null,"deleted_datetime":null,"group":null,"tags":["sale","promo"],"meta":[]},"usage":{"limit":500,"used":3,"remaining":497}}'));

        $client->links()->delete(123);

        $requests = $mockHttpClient->getRequests();
        $this->assertCount(1, $requests);

        $this->assertSame('https://lix.li/api/1.0/links/123', (string)$requests[0]->getUri());
        $this->assertSame('[]', $requests[0]->getBody()->getContents());
        $this->assertSame('DELETE', $requests[0]->getMethod());
        $this->assertSame('lix_test_some_key1', $requests[0]->getHeaderLine('X-Api-key'));
        $this->assertSame('lix-php-sdk/0.1.0', $requests[0]->getHeaderLine('User-Agent'));
    }

    // Get link example test
    public function testGetLink(): void
    {
        $mockHttpClient = self::getHttpClient();
        $client         = self::initClient('lix_test_some_key1');

        $mockHttpClient->addToResponseChain(new Response(201, [], '{"data":{"id":79697,"alias":"demo2","short_url":"https://lix.li/demo2","url":"https://example.com","is_public":true,"title":null,"created_datetime":"2026-05-27T22:16:22+03:00","active_before_datetime":null,"deleted_datetime":null,"group":null,"tags":["sale","promo"],"meta":[]},"usage":{"limit":500,"used":3,"remaining":497}}'));

        $link = $client->links()->get(123);

        $requests = $mockHttpClient->getRequests();
        $this->assertCount(1, $requests);

        $this->assertSame('https://lix.li/api/1.0/links/123', (string)$requests[0]->getUri());
        $this->assertSame('[]', $requests[0]->getBody()->getContents());
        $this->assertSame('GET', $requests[0]->getMethod());
        $this->assertSame('lix_test_some_key1', $requests[0]->getHeaderLine('X-Api-key'));
        $this->assertSame('lix-php-sdk/0.1.0', $requests[0]->getHeaderLine('User-Agent'));

        $this->assertSame('https://lix.li/demo2', $link->shortUrl);
        $this->assertSame('https://example.com', $link->url);
    }

    // Get links example test
    public function testGetLinks(): void
    {
        $mockHttpClient = self::getHttpClient();
        $client         = self::initClient('lix_test_some_key1');

        $mockHttpClient->addToResponseChain(new Response(200, [], '{"data":[{"id":79618,"alias":"a2Ag4","short_url":"https://lix.li/a2Ag4","url":"https://example.com?utm_source=Google&utm_medium=email&utm_campaign=promocode&utm_content=buy","is_public":true,"title":"Promo","created_datetime":"2026-05-21T23:35:02+03:00","active_before_datetime":"2029-05-21T21:25:40+03:00","deleted_datetime":null,"group":{"id":1005,"alias":"2222","url":"https://lix.li/g/2222","name":"Test","is_rotate":false,"description":"df","created_datetime":"2026-05-18T01:55:50+03:00","deactivated_datetime":null},"tags":["promo","sale"],"meta":{"title":"Promo","og:title":"Promo","description":"Promo sale","og:image":"null"}},{"id":79615,"alias":"oSCZ0mP","short_url":"https://lix.li/oSCZ0mP","url":"https://console.cloud.google.com/auth/verification","is_public":true,"title":null,"created_datetime":"2026-05-18T03:31:12+03:00","active_before_datetime":null,"deleted_datetime":null,"group":null,"tags":[],"meta":{"title":"some title","description":"Descr"}}],"meta":{"total":5,"limit":2,"next_url":"https://lix.local/api/1.0/links?from_id=79615&limit=2&created_date_from=2026-04-24T17%3A38%3A42%2B03%3A00&created_date_to=2026-06-08T14%3A11%3A22%2B03%3A00"}}'));

        $linksResponse = $client->links()->list();

        $this->assertSame('https://lix.li/a2Ag4', $linksResponse->links[0]->shortUrl);
        $this->assertSame('https://lix.li/oSCZ0mP', $linksResponse->links[1]->shortUrl);

        $requests = $mockHttpClient->getRequests();
        $this->assertCount(1, $requests);

        $this->assertSame('https://lix.li/api/1.0/links', (string)$requests[0]->getUri());
        $this->assertSame('[]', $requests[0]->getBody()->getContents());
        $this->assertSame('GET', $requests[0]->getMethod());
        $this->assertSame('lix_test_some_key1', $requests[0]->getHeaderLine('X-Api-key'));
        $this->assertSame('lix-php-sdk/0.1.0', $requests[0]->getHeaderLine('User-Agent'));
    }

    // Get links with pagination example test
    public function testGetLinksWithPagination(): void
    {
        $mockHttpClient = self::getHttpClient();
        $client         = self::initClient('lix_test_some_key1');

        $mockHttpClient->addToResponseChain(new Response(200, [], '{"data":[{"id":79618,"alias":"a2Ag4","short_url":"https://lix.li/a2Ag4","url":"https://example.com?utm_source=Google&utm_medium=email&utm_campaign=promocode&utm_content=buy","is_public":true,"title":"Promo","created_datetime":"2026-05-21T23:35:02+03:00","active_before_datetime":"2029-05-21T21:25:40+03:00","deleted_datetime":null,"group":{"id":1005,"alias":"2222","url":"https://lix.li/g/2222","name":"Test","is_rotate":false,"description":"df","created_datetime":"2026-05-18T01:55:50+03:00","deactivated_datetime":null},"tags":["promo","sale"],"meta":{"title":"Promo","og:title":"Promo","description":"Promo sale","og:image":"null"}},{"id":79615,"alias":"oSCZ0mP","short_url":"https://lix.li/oSCZ0mP","url":"https://console.cloud.google.com/auth/verification","is_public":true,"title":null,"created_datetime":"2026-05-18T03:31:12+03:00","active_before_datetime":null,"deleted_datetime":null,"group":null,"tags":[],"meta":{"title":"some title","description":"Descr"}}],"meta":{"total":5,"limit":2,"next_url":"https://lix.local/api/1.0/links?from_id=79615&limit=2&created_date_from=2026-04-24T17%3A38%3A42%2B03%3A00&created_date_to=2026-06-08T14%3A11%3A22%2B03%3A00"}}'));

        $linksResponse = $client->links()->list(
            limit: 100,
            fromId: 500
        );

        $this->assertSame('https://lix.li/a2Ag4', $linksResponse->links[0]->shortUrl);
        $this->assertSame('https://lix.li/oSCZ0mP', $linksResponse->links[1]->shortUrl);

        $requests = $mockHttpClient->getRequests();
        $this->assertCount(1, $requests);

        $this->assertSame('https://lix.li/api/1.0/links?limit=100&from_id=500', (string)$requests[0]->getUri());
        $this->assertSame('[]', $requests[0]->getBody()->getContents());
        $this->assertSame('GET', $requests[0]->getMethod());
        $this->assertSame('lix_test_some_key1', $requests[0]->getHeaderLine('X-Api-key'));
        $this->assertSame('lix-php-sdk/0.1.0', $requests[0]->getHeaderLine('User-Agent'));
    }

    // Create a Link with Custom Alias example test
    public function testCreateLinkWithAlias(): void
    {
        $mockHttpClient = self::getHttpClient();
        $client         = self::initClient('lix_test_some_key1');

        $mockHttpClient->addToResponseChain(new Response(201, [], '{"data":{"id":79697,"alias":"my-link","short_url":"https://lix.li/my-link","url":"https://example.com","is_public":true,"title":null,"created_datetime":"2026-05-27T22:16:22+03:00","active_before_datetime":null,"deleted_datetime":null,"group":null,"tags":["sale","promo"],"meta":[]},"usage":{"limit":500,"used":3,"remaining":497}}'));

        $link = $client->links()->create(
            url: 'https://example.com',
            alias: 'my-link'
        );

        $requests = $mockHttpClient->getRequests();
        $this->assertCount(1, $requests);

        $this->assertSame('https://lix.li/api/1.0/links', (string)$requests[0]->getUri());
        $this->assertSame('{"group_id":null,"url":"https://example.com","alias":"my-link","password":null,"title":null,"tags":[],"is_public":true,"tracking_pixel_ids":[],"meta":[],"utm":[],"active_before_datetime":null}', $requests[0]->getBody()->getContents());
        $this->assertSame('POST', $requests[0]->getMethod());
        $this->assertSame('lix_test_some_key1', $requests[0]->getHeaderLine('X-Api-key'));
        $this->assertSame('lix-php-sdk/0.1.0', $requests[0]->getHeaderLine('User-Agent'));

        $this->assertSame('https://lix.li/my-link', $link->link->shortUrl);
        $this->assertSame('https://example.com', $link->link->url);
    }

    // Create a Link with UTM Parameters
    public function testCreateLinkWithUtm(): void
    {
        $mockHttpClient = self::getHttpClient();
        $client         = self::initClient('lix_test_some_key1');

        $mockHttpClient->addToResponseChain(new Response(201, [], '{"data":{"id":79697,"alias":"my-link","short_url":"https://lix.li/my-link","url":"https://example.com","is_public":true,"title":null,"created_datetime":"2026-05-27T22:16:22+03:00","active_before_datetime":null,"deleted_datetime":null,"group":null,"tags":["sale","promo"],"meta":[]},"usage":{"limit":500,"used":3,"remaining":497}}'));

        $link = $client->links()->create(
            url: 'https://example.com',
            utm: [
                'source' => 'newsletter',
                'medium' => 'email',
                'campaign' => 'summer-sale',
            ]
        );

        $requests = $mockHttpClient->getRequests();
        $this->assertCount(1, $requests);

        $this->assertSame('https://lix.li/api/1.0/links', (string)$requests[0]->getUri());
        $this->assertSame('{"group_id":null,"url":"https://example.com","alias":null,"password":null,"title":null,"tags":[],"is_public":true,"tracking_pixel_ids":[],"meta":[],"utm":{"source":"newsletter","medium":"email","campaign":"summer-sale"},"active_before_datetime":null}', $requests[0]->getBody()->getContents());
        $this->assertSame('POST', $requests[0]->getMethod());
        $this->assertSame('lix_test_some_key1', $requests[0]->getHeaderLine('X-Api-key'));
        $this->assertSame('lix-php-sdk/0.1.0', $requests[0]->getHeaderLine('User-Agent'));

        $this->assertSame('https://lix.li/my-link', $link->link->shortUrl);
        $this->assertSame('https://example.com', $link->link->url);
    }

    // Profile example test
    public function testProfile(): void
    {
        $mockHttpClient = self::getHttpClient();
        $client         = self::initClient('lix_test_some_key1');

        $mockHttpClient->addToResponseChain(new Response(200, [], '{"client":{"id":1022,"name":"Test Client","email":"test@lix.li","created_datetime":"2022-04-24T17:38:42+03:00"},"user":{"name":"John Doe","email":"test_user@lix.li","created_datetime":"2023-04-14T17:38:42+03:00"},"plan":{"id":2,"name":"Pro","start_datetime":"2026-05-09T13:12:46+03:00","end_datetime":"2027-05-09T13:12:46+03:00"},"usage":{"links":{"limit":null,"used":1,"remaining":null},"api_links":{"limit":500,"used":100,"remaining":400},"mass_links":{"limit":100,"used":10,"remaining":90}}}'));

        $profile = $client->profile()->me();

        $requests = $mockHttpClient->getRequests();
        $this->assertCount(1, $requests);

        $this->assertSame('https://lix.li/api/1.0/me', (string)$requests[0]->getUri());
        $this->assertSame('[]', $requests[0]->getBody()->getContents());
        $this->assertSame('GET', $requests[0]->getMethod());
        $this->assertSame('lix_test_some_key1', $requests[0]->getHeaderLine('X-Api-key'));
        $this->assertSame('lix-php-sdk/0.1.0', $requests[0]->getHeaderLine('User-Agent'));
        $this->assertSame('test_user@lix.li', $profile->user->email);
    }

    // Create group example test
    public function testCreateGroup(): void
    {
        $mockHttpClient = self::getHttpClient();
        $client         = self::initClient('lix_test_some_key1');

        $mockHttpClient->addToResponseChain(new Response(201, [], '{"data":{"id":1503,"alias":"demo","url":"https://lix.li/g/demo","name":"Marketing","is_rotate":false,"description":"Marketing group","created_datetime":"2026-05-21T22:08:37+03:00","deactivated_datetime":null}}'));

        $group = $client->groups()->create(
            name: 'Marketing'
        );

        $requests = $mockHttpClient->getRequests();
        $this->assertCount(1, $requests);

        $this->assertSame('https://lix.li/api/1.0/groups', (string) $requests[0]->getUri());
        $this->assertSame('{"name":"Marketing","description":null,"is_rotate":false}', $requests[0]->getBody()->getContents());
        $this->assertSame('POST', $requests[0]->getMethod());
        $this->assertSame('lix_test_some_key1', $requests[0]->getHeaderLine('X-Api-key'));
        $this->assertSame('lix-php-sdk/0.1.0', $requests[0]->getHeaderLine('User-Agent'));

        $this->assertSame('Marketing', $group->name);
    }

    // Create a Rotating Group example test
    public function testCreateGroupWithRotation(): void
    {
        $mockHttpClient = self::getHttpClient();
        $client         = self::initClient('lix_test_some_key1');

        $mockHttpClient->addToResponseChain(new Response(201, [], '{"data":{"id":1503,"alias":"demo","url":"https://lix.li/g/demo","name":"Landing Pages","is_rotate":true,"description":"Marketing group","created_datetime":"2026-05-21T22:08:37+03:00","deactivated_datetime":null}}'));

        $group = $client->groups()->create(
            name: 'Landing Pages',
            isRotate: true
        );

        $requests = $mockHttpClient->getRequests();
        $this->assertCount(1, $requests);

        $this->assertSame('https://lix.li/api/1.0/groups', (string) $requests[0]->getUri());
        $this->assertSame('{"name":"Landing Pages","description":null,"is_rotate":true}', $requests[0]->getBody()->getContents());
        $this->assertSame('POST', $requests[0]->getMethod());
        $this->assertSame('lix_test_some_key1', $requests[0]->getHeaderLine('X-Api-key'));
        $this->assertSame('lix-php-sdk/0.1.0', $requests[0]->getHeaderLine('User-Agent'));

        $this->assertSame('Landing Pages', $group->name);
        $this->assertSame(true, $group->isRotate);
    }

    // Get Group example test
    public function testGetGroup(): void
    {
        $mockHttpClient = self::getHttpClient();
        $client         = self::initClient('lix_test_some_key1');

        $mockHttpClient->addToResponseChain(new Response(200, [], '{"data":{"id":10,"alias":"demo","url":"https://lix.li/g/demo","name":"Seller group","is_rotate":false,"description":"Marketing group","created_datetime":"2026-05-21T22:08:37+03:00","deactivated_datetime":null}}'));

        $group = $client->groups()->get(10);
        $requests = $mockHttpClient->getRequests();
        $this->assertCount(1, $requests);

        $this->assertSame('https://lix.li/api/1.0/groups/10', (string) $requests[0]->getUri());
        $this->assertSame('[]', $requests[0]->getBody()->getContents());
        $this->assertSame('GET', $requests[0]->getMethod());
        $this->assertSame('lix_test_some_key1', $requests[0]->getHeaderLine('X-Api-key'));
        $this->assertSame('lix-php-sdk/0.1.0', $requests[0]->getHeaderLine('User-Agent'));

        $this->assertSame('Seller group', $group->name);
    }

    // Update Group example test
    public function testUpdateGroup(): void
    {
        $mockHttpClient = self::getHttpClient();
        $client         = self::initClient('lix_test_some_key1');

        $mockHttpClient->addToResponseChain(new Response(200, [], '{"data":{"id":1503,"alias":"demo","url":"https://lix.li/g/demo","name":"Seller group","is_rotate":false,"description":"Updated description","created_datetime":"2026-05-21T22:08:37+03:00","deactivated_datetime":null}}'));

        $group = $client->groups()->update(
            groupId: 10,
            description: 'Updated description'
        );
        $requests = $mockHttpClient->getRequests();
        $this->assertCount(1, $requests);

        $this->assertSame('https://lix.li/api/1.0/groups/10', (string) $requests[0]->getUri());
        $this->assertSame('{"name":null,"description":"Updated description","is_rotate":false}', $requests[0]->getBody()->getContents());
        $this->assertSame('PATCH', $requests[0]->getMethod());
        $this->assertSame('lix_test_some_key1', $requests[0]->getHeaderLine('X-Api-key'));
        $this->assertSame('lix-php-sdk/0.1.0', $requests[0]->getHeaderLine('User-Agent'));

        $this->assertSame('Seller group', $group->name);
    }

    // Delete Group example test
    public function testDeleteGroup(): void
    {
        $mockHttpClient = self::getHttpClient();
        $client         = self::initClient('lix_test_some_key1');

        $mockHttpClient->addToResponseChain(new Response(200, [], '{"data":{"id":1503,"alias":"demo","url":"https://lix.li/g/demo","name":"Seller group","is_rotate":false,"description":"Updated description","created_datetime":"2026-05-21T22:08:37+03:00","deactivated_datetime":null}}'));

        $client->groups()->delete(10);

        $requests = $mockHttpClient->getRequests();
        $this->assertCount(1, $requests);

        $this->assertSame('https://lix.li/api/1.0/groups/10', (string) $requests[0]->getUri());
        $this->assertSame('[]', $requests[0]->getBody()->getContents());
        $this->assertSame('DELETE', $requests[0]->getMethod());
        $this->assertSame('lix_test_some_key1', $requests[0]->getHeaderLine('X-Api-key'));
        $this->assertSame('lix-php-sdk/0.1.0', $requests[0]->getHeaderLine('User-Agent'));
    }

    // Get Groups example test
    public function testGetGroups(): void
    {
        $mockHttpClient = self::getHttpClient();
        $client         = self::initClient('lix_test_some_key1');

        $mockHttpClient->addToResponseChain(new Response(200, [], '{"data":[{"id":1503,"alias":"demo","url":"https://lix.li/g/demo","name":"Seller group","is_rotate":false,"description":"Marketing group","created_datetime":"2026-05-21T22:08:37+03:00","deactivated_datetime":null}],"meta":{"total":1,"limit":20,"next_url":null}}'));

        $response = $client->groups()->list(limit: 10, fromId: 1000);

        $this->assertSame('https://lix.li/g/demo', $response->groups[0]->url);

        $requests = $mockHttpClient->getRequests();
        $this->assertCount(1, $requests);

        $this->assertSame('https://lix.li/api/1.0/groups?limit=10&from_id=1000', (string) $requests[0]->getUri());
        $this->assertSame('[]', $requests[0]->getBody()->getContents());
        $this->assertSame('GET', $requests[0]->getMethod());
        $this->assertSame('lix_test_some_key1', $requests[0]->getHeaderLine('X-Api-key'));
        $this->assertSame('lix-php-sdk/0.1.0', $requests[0]->getHeaderLine('User-Agent'));
    }
}
