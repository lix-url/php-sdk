<?php

declare(strict_types=1);


use GuzzleHttp\Psr7\Response;
use Lix\Tests\TestCase;

final class UpdateLinkTest extends TestCase
{
    // Testing Link DTO structure after update
    public function testUpdateLinkResponseStructure(): void
    {
        $mockHttpClient = self::getHttpClient();
        $client = self::initClient();

        $mockHttpClient->addToResponseChain(new Response(200, [], '{"data":{"id":79697,"alias":"demo","short_url":"https://lix.li/demo","url":"https://example.com/very/long/page","is_public":true,"title":"Some Title","created_datetime":"2026-05-27T22:16:22+03:00","active_before_datetime":null,"deleted_datetime":null,"group":{"id":1503,"alias":"demo","url":"https://lix.li/g/demo","name":"Seller group","is_rotate":false,"description":"Marketing group","created_datetime":"2026-05-21T22:08:37+03:00","deactivated_datetime":null},"tags":["sale","promo"],"meta":{"title":"Awesome sale!","og:title":"Awesome sale!!!!","description":"Woooooo, its wonderful!","og:description":"Woooowww, its wonderful!","keywords":"sale, promo"}},"usage":{"limit":500,"used":3,"remaining":497}}'));

        $linkResponse = $client->links()->update(79697, 'https://example.com/very/long/page');

        $link = $linkResponse->link;

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

        $this->assertSame(500, $linkResponse->usage->limit);
        $this->assertSame(497, $linkResponse->usage->remaining);
        $this->assertSame(3, $linkResponse->usage->used);
    }

    // Testing the update link request structure
    public function testRequestUpdateLink(): void
    {
        $mockHttpClient = self::getHttpClient();
        $client = self::initClient('lix_test_some_key1');

        $mockHttpClient->addToResponseChain(new Response(200, [], '{"data":{"id":79697,"alias":"demo2","short_url":"https://lix.li/demo2","url":"https://example.com/very/long/page","is_public":true,"title":null,"created_datetime":"2026-05-27T22:16:22+03:00","active_before_datetime":null,"deleted_datetime":null,"group":null,"tags":["sale","promo"],"meta":[]},"usage":{"limit":500,"used":3,"remaining":497}}'));

        $client->links()->update(
            79697,
            'https://example.com/very/long/page',
            'Some Title',
            1000,
            ['sale', 'promo'],
            [
                'title'          => 'Awesome sale!',
                'og:title'       => 'Awesome sale!!!!',
                'description'    => 'Woooooo, its wonderful!',
                'og:description' => 'Woooowww, its wonderful!',
                'keywords'       => 'sale, promp',
            ],
            [
                'utm_source'   => 'google ads',
                'utm_medium'   => 'email',
                'utm_campaign' => 'sale',
                'utm_content'  => 'buy',
                'utm_term'     => 'banner',
            ],
            [1110, 1023],
            '2029-05-21T21:25:40+03:00',
            '12345',
            true
        );

        $requests = $mockHttpClient->getRequests();
        $this->assertCount(1, $requests);

        $this->assertSame('https://lix.li/api/1.0/links/79697', (string) $requests[0]->getUri());
        $this->assertSame('{"group_id":1000,"url":"https://example.com/very/long/page","password":"12345","title":"Some Title","tags":["sale","promo"],"is_public":true,"tracking_pixel_ids":[1110,1023],"meta":{"title":"Awesome sale!","og:title":"Awesome sale!!!!","description":"Woooooo, its wonderful!","og:description":"Woooowww, its wonderful!","keywords":"sale, promp"},"utm":{"utm_source":"google ads","utm_medium":"email","utm_campaign":"sale","utm_content":"buy","utm_term":"banner"},"active_before_datetime":"2029-05-21T21:25:40+03:00"}', $requests[0]->getBody()->getContents());
        $this->assertSame('PATCH', $requests[0]->getMethod());
        $this->assertSame('lix_test_some_key1', $requests[0]->getHeaderLine('X-Api-key'));
        $this->assertSame('lix-php-sdk/0.1.0', $requests[0]->getHeaderLine('User-Agent'));
    }
}
