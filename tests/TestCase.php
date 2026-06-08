<?php

namespace Lix\Tests;

use Lix\Client;
use \PHPUnit\Framework\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    private static $httpClient;


    public function setUp(): void
    {
        parent::setUp();
        self::getHttpClient()->clear();
    }

    protected static function initClient(string $apiKey = 'lix_test_123'): Client
    {
        return new Client($apiKey, self::getHttpClient());
    }

    protected static function getHttpClient(): MockHttpClient
    {
        if (self::$httpClient === null) {
            self::$httpClient = new MockHttpClient();
        }

        return self::$httpClient;
    }
}
