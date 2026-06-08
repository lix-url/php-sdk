<?php

namespace Lix\Tests;


use GuzzleHttp\Psr7\Response;
use Lix\Exceptions\HttpClientException;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * PSR-18 HttpClient
 */
class MockHttpClient implements ClientInterface
{
    /** @var RequestInterface[] */
    private array $requests = [];

    /** @var ResponseInterface[] */
    private array $responses = [];

    private bool $isResponseChainInited = false;

    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        $this->requests[] = $request;
        if ($this->isResponseChainInited && !count($this->responses)) {
            throw new HttpClientException('No responses in the chain');
        }

        return $this->isResponseChainInited ? array_shift($this->responses) : new Response(200, [], '');
    }

    public function addToResponseChain(ResponseInterface $response): self
    {
        $this->isResponseChainInited = true;

        $this->responses[] = $response;
        return $this;
    }

    /** @return RequestInterface[] */
    public function getRequests(): array
    {
        return $this->requests;
    }

    public function clear(): MockHttpClient
    {
        $this->requests  = [];
        $this->responses = [];

        $this->isResponseChainInited = false;

        return $this;
    }
}
