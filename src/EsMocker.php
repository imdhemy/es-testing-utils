<?php

namespace EsUtils;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class EsMocker
 * This class is used to mock responses for Elasticsearch requests.
 */
class EsMocker
{
    /**
     * @var ResponseInterface[]|ClientExceptionInterface[]
     */
    private array $mockResponses = [];

    /**
     * Creates a new EsMocker instance.
     * @param array $body
     * @param int $statusCode
     *
     * @return EsMocker
     */
    public static function mock(array $body, int $statusCode = 200): EsMocker
    {
        $response = new Response(json_encode($body), $statusCode);
        $mocker = new self();
        $mocker->mockResponses[] = $response;

        return $mocker;
    }

    /**
     * Enqueues a response to be returned when the next request is made.
     * @param array $body
     * @param int $statusCode
     *
     * @return EsMocker
     */
    public function then(array $body, int $statusCode = 200): EsMocker
    {
        $response = new Response(json_encode($body), $statusCode);
        $this->mockResponses[] = $response;

        return $this;
    }

    /**
     * Enqueues a request exception to be thrown when the next request is made.
     * @param string $string
     *
     * @return $this
     */
    public function fail(string $string): EsMocker
    {
        $requestException = new RequestException($string);
        $this->mockResponses[] = $requestException;

        return $this;
    }

    /**
     * Builds a client that uses the mocked responses.
     * @throws AuthenticationException
     */
    public function build(): Client
    {
        $httpClient = HttpClientFactory::mock($this->mockResponses);

        return ClientBuilder::create()->setHttpClient($httpClient)->build();
    }
}
