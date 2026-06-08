<?php

declare(strict_types=1);


use GuzzleHttp\Psr7\Response;
use Lix\Tests\TestCase;

final class DeleteLinkTest extends TestCase
{
    // Testing the delete link request structure
    public function testRequestDeleteLink(): void
    {
        $mockHttpClient = self::getHttpClient();
        $client = self::initClient('lix_test_some_key1');

        $mockHttpClient->addToResponseChain(new Response(200, [], ''));

        $client->links()->delete(1503);

        $requests = $mockHttpClient->getRequests();
        $this->assertCount(1, $requests);

        $this->assertSame('https://lix.li/api/1.0/links/1503', (string) $requests[0]->getUri());
        $this->assertSame('[]', $requests[0]->getBody()->getContents());
        $this->assertSame('DELETE', $requests[0]->getMethod());
        $this->assertSame('lix_test_some_key1', $requests[0]->getHeaderLine('X-Api-key'));
        $this->assertSame('lix-php-sdk/0.1.0', $requests[0]->getHeaderLine('User-Agent'));
    }
}
