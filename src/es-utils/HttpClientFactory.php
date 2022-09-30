<?php

namespace Imdhemy\EsUtils;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class HttpClientFactory
 * This class is used to create a PSR-18 client that can be used to mock the Elasticsearch client.
 * It supports single or multiple responses, and can be used to simulate a failure.
 */
class HttpClientFactory
{
    /**
     * Mocks a single or multiple responses.
     * @param array|ResponseInterface $responses
     * @param array $transactions
     * @param-out mixed|array|\ArrayAccess<int, array> $transactions
     *
     * @return ClientInterface
     */
    public static function mock($responses, array &$transactions = []): ClientInterface
    {
        $queue = $responses instanceof ResponseInterface ? [$responses] : $responses;
        $mockHandler = new MockHandler($queue);

        $handlerStack = HandlerStack::create($mockHandler);
        $history = Middleware::history($transactions);

        $handlerStack->push($history);

        return new Client(['handler' => $handlerStack]);
    }
}
