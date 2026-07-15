<?php
declare(strict_types=1);

namespace Lix\Tests;

use GuzzleHttp\Psr7\Response;
use Lix\Exceptions\ConflictException;
use Lix\Exceptions\NotFoundException;
use Lix\Exceptions\PlanLimitException;
use Lix\Exceptions\RateLimitException;
use Lix\Exceptions\ServerException;
use Lix\Exceptions\UnauthorizedException;
use Lix\Exceptions\UnprocessableEntity;
use Lix\Exceptions\ValidationException;

final class ExceptionsTest extends TestCase
{
    public function testGroupCreateValidationErrors(): void
    {
        $mockHttpClient = self::getHttpClient();
        $client         = self::initClient('lix_test_some_key1');

        $mockHttpClient->addToResponseChain(new Response(400, [], '{"error":"invalid_parameters","parameter_errors":{"name":{"code":"required","message":"field required"}},"error_message":null}'));

        try {
            $client->groups()->create('test');
        } catch (ValidationException $e) {
            $this->assertTrue(true);
            $this->assertSame(['name' => ['code' => 'required', 'message' => 'field required']], $e->data);
        }
    }

    public function testGroupCreateUnprocessableEntityErrors(): void
    {
        $mockHttpClient = self::getHttpClient();
        $client         = self::initClient('lix_test_some_key1');

        $mockHttpClient->addToResponseChain(new Response(422, [], '{"error":"business_logic_exception","parameter_errors":[],"error_message":"Tags limit exceeded for your current plan."}'));

        try {
            $client->groups()->create('test');
        } catch (UnprocessableEntity $e) {
            $this->assertTrue(true);
        }
    }

    public function testGroupCreateConflictErrors(): void
    {
        $mockHttpClient = self::getHttpClient();
        $client         = self::initClient('lix_test_some_key1');

        $mockHttpClient->addToResponseChain(new Response(409, [], '{"error":"alias_already_exists","parameter_errors":[],"error_message":"This alias is already in use. Please choose another one."}'));

        try {
            $client->groups()->create('test');
        } catch (ConflictException $e) {
            $this->assertTrue(true);
        }
    }

    public function testGroupCreatePlanLimitExceededErrors(): void
    {
        $mockHttpClient = self::getHttpClient();
        $client         = self::initClient('lix_test_some_key1');

        $mockHttpClient->addToResponseChain(new Response(422, [], '{"error":"plan_limit_exceeded","parameter_errors":[],"error_message":"Tags limit exceeded for your current plan.","limit_type":"tags_per_link","limit":0,"requested":3}'));

        try {
            $client->groups()->create('test');
        } catch (PlanLimitException $e) {
            $this->assertTrue(true);

            $this->assertSame(
                [
                    'error'            => 'plan_limit_exceeded',
                    'parameter_errors' => [],
                    'error_message'    => 'Tags limit exceeded for your current plan.',
                    'limit_type'       => 'tags_per_link',
                    'limit'            => 0,
                    'requested'        => 3,
                ], $e->getErrorData());
        }
    }

    /** @dataProvider groupsErrorTestDataProvider */
    public function testGroupApiErrors(int $httpCode, string $method, mixed $param, string $exception, ?string $errorMessage = null): void
    {
        $mockHttpClient = self::getHttpClient();
        $client         = self::initClient('lix_test_some_key1');

        $mockHttpClient->addToResponseChain(new Response($httpCode, [], ''));

        $this->expectException($exception);
        $client->groups()->{$method}($param);

        if ($errorMessage) {
            $this->expectExceptionMessage($errorMessage);
        }
    }

    public static function groupsErrorTestDataProvider(): array
    {
        return [
            [401, 'get', 1, UnauthorizedException::class,],
            [404, 'get', 1, NotFoundException::class,],
            [429, 'get', 1, RateLimitException::class,],
            [500, 'get', 1, ServerException::class,],
            [422, 'get', 1, UnprocessableEntity::class, 'Tags limit exceeded for your current plan.'],

            [401, 'list', null, UnauthorizedException::class,],
            [404, 'list', null, NotFoundException::class,],
            [429, 'list', null, RateLimitException::class,],
            [500, 'list', null, ServerException::class,],
            [422, 'list', null, UnprocessableEntity::class, 'Tags limit exceeded for your current plan.'],

            [401, 'delete', 1, UnauthorizedException::class,],
            [404, 'delete', 1, NotFoundException::class,],
            [429, 'delete', 1, RateLimitException::class,],
            [500, 'delete', 1, ServerException::class,],
            [422, 'delete', 1, UnprocessableEntity::class, 'Tags limit exceeded for your current plan.'],

            [401, 'create', 'test', UnauthorizedException::class,],
            [404, 'create', 'test', NotFoundException::class,],
            [429, 'create', 'test', RateLimitException::class,],
            [500, 'create', 'test', ServerException::class,],
            [422, 'create', 'test', UnprocessableEntity::class, 'Tags limit exceeded for your current plan.'],

            [401, 'update', 1, UnauthorizedException::class,],
            [404, 'update', 1, NotFoundException::class,],
            [429, 'update', 1, RateLimitException::class,],
            [500, 'update', 1, ServerException::class,],
            [422, 'update', 1, UnprocessableEntity::class, 'Tags limit exceeded for your current plan.'],
        ];
    }

    /** @dataProvider linksErrorTestDataProvider */
    public function testLinkApiErrors(int $httpCode, string $method, mixed $param, string $exception): void
    {
        $mockHttpClient = self::getHttpClient();
        $client         = self::initClient('lix_test_some_key1');

        $mockHttpClient->addToResponseChain(new Response($httpCode, [], ''));

        $this->expectException($exception);
        $client->links()->{$method}($param);
    }

    public static function linksErrorTestDataProvider(): array
    {
        return [
            [401, 'get', 1, UnauthorizedException::class,],
            [404, 'get', 1, NotFoundException::class,],
            [429, 'get', 1, RateLimitException::class,],
            [500, 'get', 1, ServerException::class,],
            [422, 'get', 1, UnprocessableEntity::class, 'Tags limit exceeded for your current plan.'],

            [401, 'list', null, UnauthorizedException::class,],
            [404, 'list', null, NotFoundException::class,],
            [429, 'list', null, RateLimitException::class,],
            [500, 'list', null, ServerException::class,],
            [422, 'list', null, UnprocessableEntity::class, 'Tags limit exceeded for your current plan.'],

            [401, 'delete', 1, UnauthorizedException::class,],
            [404, 'delete', 1, NotFoundException::class,],
            [429, 'delete', 1, RateLimitException::class,],
            [500, 'delete', 1, ServerException::class,],
            [422, 'delete', 1, UnprocessableEntity::class, 'Tags limit exceeded for your current plan.'],

            [401, 'create', 'test', UnauthorizedException::class,],
            [404, 'create', 'test', NotFoundException::class,],
            [429, 'create', 'test', RateLimitException::class,],
            [500, 'create', 'test', ServerException::class,],
            [422, 'create', 'test', UnprocessableEntity::class, 'Tags limit exceeded for your current plan.'],

            [401, 'update', 1, UnauthorizedException::class,],
            [404, 'update', 1, NotFoundException::class,],
            [429, 'update', 1, RateLimitException::class,],
            [500, 'update', 1, ServerException::class,],
            [422, 'update', 1, UnprocessableEntity::class, 'Tags limit exceeded for your current plan.'],
        ];
    }
}
