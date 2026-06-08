<?php

declare(strict_types=1);


use GuzzleHttp\Psr7\Response;
use Lix\Tests\TestCase;

final class GetLinkTest extends TestCase
{
    // Testing Link DTO structure
    public function testGetLink(): void
    {
        $mockHttpClient = self::getHttpClient();
        $client = self::initClient();

        $mockHttpClient->addToResponseChain(new Response(200, [], '{"data":{"id":79697,"alias":"demo","short_url":"https://lix.li/demo","url":"https://example.com/very/long/page","is_public":true,"title":"Some Title","created_datetime":"2026-05-27T22:16:22+03:00","active_before_datetime":null,"deleted_datetime":null,"group":{"id":1503,"alias":"demo","url":"https://lix.li/g/demo","name":"Seller group","is_rotate":false,"description":"Marketing group","created_datetime":"2026-05-21T22:08:37+03:00","deactivated_datetime":null},"tags":["sale","promo"],"meta":{"title":"Awesome sale!","og:title":"Awesome sale!!!!","description":"Woooooo, its wonderful!","og:description":"Woooowww, its wonderful!","keywords":"sale, promo"}},"usage":{"limit":500,"used":3,"remaining":497}}'));

        $link = $client->links()->get(79697);

        $this->assertSame(79697, $link->id);
        $this->assertSame('Some Title', $link->title);
        $this->assertSame(
            [
                "title"          => "Awesome sale!",
                "og:title"       => "Awesome sale!!!!",
                "description"    => "Woooooo, its wonderful!",
                "og:description" => "Woooowww, its wonderful!",
                "keywords"       => "sale, promo"
            ], $link->meta);

        $this->assertSame('2026-05-27T22:16:22+03:00', $link->createdDatetime);
        $this->assertSame('demo', $link->alias);
        $this->assertSame('https://lix.li/demo', $link->shortUrl);
        $this->assertSame('https://example.com/very/long/page', $link->url);
        $this->assertSame(true, $link->isPublic);
        $this->assertSame(null, $link->activeBeforeDatetime);
        $this->assertSame(null, $link->deletedDatetime);
        $this->assertSame(['sale', 'promo'], $link->tags);

        $group = $link->group;
        $this->assertSame(1503, $group->id);
        $this->assertSame('demo', $group->alias);
        $this->assertSame('https://lix.li/g/demo', $group->url);
        $this->assertSame(false, $group->isRotate);
        $this->assertSame(null, $group->deactivatedDatetime);
        $this->assertSame('2026-05-21T22:08:37+03:00', $group->createdDatetime);
    }

    // Testing the get link request structure
    public function testRequestGeLink(): void
    {
        $mockHttpClient = self::getHttpClient();
        $client = self::initClient('lix_test_some_key1');

        $mockHttpClient->addToResponseChain(new Response(200, [], '{"data":{"id":79697,"alias":"demo","short_url":"https://lix.li/demo","url":"https://example.com/very/long/page","is_public":true,"title":"Some Title","created_datetime":"2026-05-27T22:16:22+03:00","active_before_datetime":null,"deleted_datetime":null,"group":{"id":1503,"alias":"demo","url":"https://lix.li/g/demo","name":"Seller group","is_rotate":false,"description":"Marketing group","created_datetime":"2026-05-21T22:08:37+03:00","deactivated_datetime":null},"tags":["sale","promo"],"meta":{"title":"Awesome sale!","og:title":"Awesome sale!!!!","description":"Woooooo, its wonderful!","og:description":"Woooowww, its wonderful!","keywords":"sale, promo"}},"usage":{"limit":500,"used":3,"remaining":497}}'));

        $client->links()->get(79697);

        $requests = $mockHttpClient->getRequests();
        $this->assertCount(1, $requests);

        $this->assertSame('https://lix.li/api/1.0/links/79697', (string) $requests[0]->getUri());
        $this->assertSame('[]', $requests[0]->getBody()->getContents());
        $this->assertSame('GET', $requests[0]->getMethod());
        $this->assertSame('lix_test_some_key1', $requests[0]->getHeaderLine('X-Api-key'));
        $this->assertSame('lix-php-sdk/0.1.0', $requests[0]->getHeaderLine('User-Agent'));
    }
}
