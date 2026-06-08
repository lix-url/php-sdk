<?php

declare(strict_types=1);


use GuzzleHttp\Psr7\Response;
use Lix\Tests\TestCase;

final class GetLinksTest extends TestCase
{
    // Testing Link DTO structure
    public function testGetLinksDtoStructure(): void
    {
        $mockHttpClient = self::getHttpClient();
        $client = self::initClient();

        $mockHttpClient->addToResponseChain(new Response(200, [], '{"data":[{"id":79618,"alias":"a2Ag4","short_url":"https://lix.li/a2Ag4","url":"https://example.com?utm_source=Google&utm_medium=email&utm_campaign=promocode&utm_content=buy","is_public":true,"title":"Promo","created_datetime":"2026-05-21T23:35:02+03:00","active_before_datetime":"2029-05-21T21:25:40+03:00","deleted_datetime":null,"group":{"id":1005,"alias":"2222","url":"https://lix.li/g/2222","name":"Test","is_rotate":false,"description":"df","created_datetime":"2026-05-18T01:55:50+03:00","deactivated_datetime":null},"tags":["promo","sale"],"meta":{"title":"Promo","og:title":"Promo","description":"Promo sale","og:image":"null"}},{"id":79615,"alias":"oSCZ0mP","short_url":"https://lix.li/oSCZ0mP","url":"https://console.cloud.google.com/auth/verification","is_public":true,"title":null,"created_datetime":"2026-05-18T03:31:12+03:00","active_before_datetime":null,"deleted_datetime":null,"group":null,"tags":[],"meta":{"title":"some title","description":"Descr"}},{"id":79613,"alias":"ycuda","short_url":"https://lix.li/ycuda","url":"https://yttt.ru?utm_medium=asdas","is_public":true,"title":null,"created_datetime":"2026-04-24T22:25:07+03:00","active_before_datetime":null,"deleted_datetime":null,"group":null,"tags":[],"meta":[]}],"meta":{"total":3,"limit":20,"next_url":null}}'));

        $linksResponse = $client->links()->list();
        $this->assertCount(3, $linksResponse->links);

        $link = $linksResponse->links[0];

        $this->assertSame(79618, $link->id);
        $this->assertSame('Promo', $link->title);
        $this->assertSame(
            [
                "title"          => "Promo",
                "og:title"       => "Promo",
                "description"    => "Promo sale",
                "og:image"       => "null"
            ], $link->meta);

        $this->assertSame('2026-05-21T23:35:02+03:00', $link->createdDatetime);
        $this->assertSame('a2Ag4', $link->alias);
        $this->assertSame('https://lix.li/a2Ag4', $link->shortUrl);
        $this->assertSame('https://example.com?utm_source=Google&utm_medium=email&utm_campaign=promocode&utm_content=buy', $link->url);
        $this->assertSame(true, $link->isPublic);
        $this->assertSame('2029-05-21T21:25:40+03:00', $link->activeBeforeDatetime);
        $this->assertSame(null, $link->deletedDatetime);
        $this->assertSame(['promo', 'sale'], $link->tags);

        $group = $link->group;
        $this->assertSame(1005, $group->id);
        $this->assertSame('2222', $group->alias);
        $this->assertSame('https://lix.li/g/2222', $group->url);
        $this->assertSame(false, $group->isRotate);
        $this->assertSame(null, $group->deactivatedDatetime);
        $this->assertSame('2026-05-18T01:55:50+03:00', $group->createdDatetime);

        // Second link
        $link = $linksResponse->links[1];

        $this->assertSame(79615, $link->id);
        $this->assertSame(null, $link->title);
        $this->assertSame(
            [
                "title"          => "some title",
                "description"    => "Descr",
            ], $link->meta);

        $this->assertSame('2026-05-18T03:31:12+03:00', $link->createdDatetime);
        $this->assertSame('oSCZ0mP', $link->alias);
        $this->assertSame('https://lix.li/oSCZ0mP', $link->shortUrl);
        $this->assertSame('https://console.cloud.google.com/auth/verification', $link->url);
        $this->assertSame(true, $link->isPublic);
        $this->assertSame(null, $link->activeBeforeDatetime);
        $this->assertSame(null, $link->deletedDatetime);
        $this->assertSame([], $link->tags);
        $this->assertSame(null, $link->group);

        // Third link
        $link = $linksResponse->links[2];

        $this->assertSame(79613, $link->id);
        $this->assertSame(null, $link->title);
        $this->assertSame([], $link->meta);
        $this->assertSame('2026-04-24T22:25:07+03:00', $link->createdDatetime);
        $this->assertSame('ycuda', $link->alias);
        $this->assertSame('https://lix.li/ycuda', $link->shortUrl);
        $this->assertSame('https://yttt.ru?utm_medium=asdas', $link->url);
        $this->assertSame(true, $link->isPublic);
        $this->assertSame(null, $link->activeBeforeDatetime);
        $this->assertSame(null, $link->deletedDatetime);
        $this->assertSame([], $link->tags);
        $this->assertSame(null, $link->group);

        $this->assertSame(20, $linksResponse->meta->limit);
        $this->assertSame(3, $linksResponse->meta->total);
        $this->assertSame(null, $linksResponse->meta->nextUrl);
    }

    // Testing get Links with some result items and pagination
    public function testGetGroupsWithPagination(): void
    {

        $mockHttpClient = self::getHttpClient();
        $client = self::initClient();

        $mockHttpClient->addToResponseChain(new Response(200, [], '{"data":[{"id":79618,"alias":"a2Ag4","short_url":"https://lix.li/a2Ag4","url":"https://example.com?utm_source=Google&utm_medium=email&utm_campaign=promocode&utm_content=buy","is_public":true,"title":"Promo","created_datetime":"2026-05-21T23:35:02+03:00","active_before_datetime":"2029-05-21T21:25:40+03:00","deleted_datetime":null,"group":{"id":1005,"alias":"2222","url":"https://lix.li/g/2222","name":"Test","is_rotate":false,"description":"df","created_datetime":"2026-05-18T01:55:50+03:00","deactivated_datetime":null},"tags":["promo","sale"],"meta":{"title":"Promo","og:title":"Promo","description":"Promo sale","og:image":"null"}},{"id":79615,"alias":"oSCZ0mP","short_url":"https://lix.li/oSCZ0mP","url":"https://console.cloud.google.com/auth/verification","is_public":true,"title":null,"created_datetime":"2026-05-18T03:31:12+03:00","active_before_datetime":null,"deleted_datetime":null,"group":null,"tags":[],"meta":{"title":"some title","description":"Descr"}}],"meta":{"total":5,"limit":2,"next_url":"https://lix.local/api/1.0/links?from_id=79615&limit=2&created_date_from=2026-04-24T17%3A38%3A42%2B03%3A00&created_date_to=2026-06-08T14%3A11%3A22%2B03%3A00"}}'));

        $linksResponse = $client->links()->list();
        $this->assertCount(2, $linksResponse->links);

        $link = $linksResponse->links[0];

        $this->assertSame(79618, $link->id);
        $this->assertSame('Promo', $link->title);
        $this->assertSame(
            [
                "title"          => "Promo",
                "og:title"       => "Promo",
                "description"    => "Promo sale",
                "og:image"       => "null"
            ], $link->meta);

        $this->assertSame('2026-05-21T23:35:02+03:00', $link->createdDatetime);
        $this->assertSame('a2Ag4', $link->alias);
        $this->assertSame('https://lix.li/a2Ag4', $link->shortUrl);
        $this->assertSame('https://example.com?utm_source=Google&utm_medium=email&utm_campaign=promocode&utm_content=buy', $link->url);
        $this->assertSame(true, $link->isPublic);
        $this->assertSame('2029-05-21T21:25:40+03:00', $link->activeBeforeDatetime);
        $this->assertSame(null, $link->deletedDatetime);
        $this->assertSame(['promo', 'sale'], $link->tags);

        $group = $link->group;
        $this->assertSame(1005, $group->id);
        $this->assertSame('2222', $group->alias);
        $this->assertSame('https://lix.li/g/2222', $group->url);
        $this->assertSame(false, $group->isRotate);
        $this->assertSame(null, $group->deactivatedDatetime);
        $this->assertSame('2026-05-18T01:55:50+03:00', $group->createdDatetime);

        // Second link
        $link = $linksResponse->links[1];

        $this->assertSame(79615, $link->id);
        $this->assertSame(null, $link->title);
        $this->assertSame(
            [
                "title"          => "some title",
                "description"    => "Descr",
            ], $link->meta);

        $this->assertSame('2026-05-18T03:31:12+03:00', $link->createdDatetime);
        $this->assertSame('oSCZ0mP', $link->alias);
        $this->assertSame('https://lix.li/oSCZ0mP', $link->shortUrl);
        $this->assertSame('https://console.cloud.google.com/auth/verification', $link->url);
        $this->assertSame(true, $link->isPublic);
        $this->assertSame(null, $link->activeBeforeDatetime);
        $this->assertSame(null, $link->deletedDatetime);
        $this->assertSame([], $link->tags);
        $this->assertSame(null, $link->group);

        $this->assertSame(2, $linksResponse->meta->limit);
        $this->assertSame(5, $linksResponse->meta->total);
        $this->assertSame('https://lix.local/api/1.0/links?from_id=79615&limit=2&created_date_from=2026-04-24T17%3A38%3A42%2B03%3A00&created_date_to=2026-06-08T14%3A11%3A22%2B03%3A00', $linksResponse->meta->nextUrl);
    }

    // Testing the get links list request structure
    public function testRequestGetLinksWithoutQuery(): void
    {
        $mockHttpClient = self::getHttpClient();
        $client = self::initClient('lix_test_some_key1');

        $mockHttpClient->addToResponseChain(new Response(200, [], '{"data":[{"id":79618,"alias":"a2Ag4","short_url":"https://lix.li/a2Ag4","url":"https://example.com?utm_source=Google&utm_medium=email&utm_campaign=promocode&utm_content=buy","is_public":true,"title":"Promo","created_datetime":"2026-05-21T23:35:02+03:00","active_before_datetime":"2029-05-21T21:25:40+03:00","deleted_datetime":null,"group":{"id":1005,"alias":"2222","url":"https://lix.li/g/2222","name":"Test","is_rotate":false,"description":"df","created_datetime":"2026-05-18T01:55:50+03:00","deactivated_datetime":null},"tags":["promo","sale"],"meta":{"title":"Promo","og:title":"Promo","description":"Promo sale","og:image":"null"}},{"id":79615,"alias":"oSCZ0mP","short_url":"https://lix.li/oSCZ0mP","url":"https://console.cloud.google.com/auth/verification","is_public":true,"title":null,"created_datetime":"2026-05-18T03:31:12+03:00","active_before_datetime":null,"deleted_datetime":null,"group":null,"tags":[],"meta":{"title":"some title","description":"Descr"}}],"meta":{"total":5,"limit":2,"next_url":"https://lix.local/api/1.0/links?from_id=79615&limit=2&created_date_from=2026-04-24T17%3A38%3A42%2B03%3A00&created_date_to=2026-06-08T14%3A11%3A22%2B03%3A00"}}'));

        $client->links()->list();

        $requests = $mockHttpClient->getRequests();
        $this->assertCount(1, $requests);

        $this->assertSame('https://lix.li/api/1.0/links', (string) $requests[0]->getUri());
        $this->assertSame('[]', $requests[0]->getBody()->getContents());
        $this->assertSame('GET', $requests[0]->getMethod());
        $this->assertSame('lix_test_some_key1', $requests[0]->getHeaderLine('X-Api-key'));
        $this->assertSame('lix-php-sdk/0.1.0', $requests[0]->getHeaderLine('User-Agent'));
    }

    // Testing the get links list request structure with query params
    public function testRequestGetLinksWithQuery(): void
    {
        $mockHttpClient = self::getHttpClient();
        $client = self::initClient('lix_test_some_key1');

        $mockHttpClient->addToResponseChain(new Response(200, [], '{"data":[{"id":79618,"alias":"a2Ag4","short_url":"https://lix.li/a2Ag4","url":"https://example.com?utm_source=Google&utm_medium=email&utm_campaign=promocode&utm_content=buy","is_public":true,"title":"Promo","created_datetime":"2026-05-21T23:35:02+03:00","active_before_datetime":"2029-05-21T21:25:40+03:00","deleted_datetime":null,"group":{"id":1005,"alias":"2222","url":"https://lix.li/g/2222","name":"Test","is_rotate":false,"description":"df","created_datetime":"2026-05-18T01:55:50+03:00","deactivated_datetime":null},"tags":["promo","sale"],"meta":{"title":"Promo","og:title":"Promo","description":"Promo sale","og:image":"null"}},{"id":79615,"alias":"oSCZ0mP","short_url":"https://lix.li/oSCZ0mP","url":"https://console.cloud.google.com/auth/verification","is_public":true,"title":null,"created_datetime":"2026-05-18T03:31:12+03:00","active_before_datetime":null,"deleted_datetime":null,"group":null,"tags":[],"meta":{"title":"some title","description":"Descr"}}],"meta":{"total":5,"limit":2,"next_url":"https://lix.local/api/1.0/links?from_id=79615&limit=2&created_date_from=2026-04-24T17%3A38%3A42%2B03%3A00&created_date_to=2026-06-08T14%3A11%3A22%2B03%3A00"}}'));

        $client->links()->list(100, 1500);

        $requests = $mockHttpClient->getRequests();
        $this->assertCount(1, $requests);

        $this->assertSame('https://lix.li/api/1.0/links?limit=100&from_id=1500', (string) $requests[0]->getUri());
        $this->assertSame('[]', $requests[0]->getBody()->getContents());
        $this->assertSame('GET', $requests[0]->getMethod());
        $this->assertSame('lix_test_some_key1', $requests[0]->getHeaderLine('X-Api-key'));
        $this->assertSame('lix-php-sdk/0.1.0', $requests[0]->getHeaderLine('User-Agent'));
    }
}
