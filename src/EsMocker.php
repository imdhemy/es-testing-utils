<?php

namespace EsUtils;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Message\ResponseInterface;

class EsMocker
{
    /**
     * @var ResponseInterface[]|ClientExceptionInterface[]
     */
    private $mockResponses = [];

    public static function mock(array $body, int $statusCode = 200): EsMocker
    {
        $response = new Response(json_encode($body), $statusCode);
        $mocker = new self();
        $mocker->mockResponses[] = $response;

        return $mocker;
    }

    public function then(array $body, int $statusCode = 200): EsMocker
    {
        $response = new Response(json_encode($body), $statusCode);
        $this->mockResponses[] = $response;

        return $this;
    }

    public function fail(string $string): EsMocker
    {
        $requestException = new RequestException($string);
        $this->mockResponses[] = $requestException;

        return $this;
    }

    /**
     * @throws AuthenticationException
     */
    public function build(): Client
    {
        $httpClient = HttpClientFactory::mock($this->mockResponses);

        return ClientBuilder::create()->setHttpClient($httpClient)->build();
    }
}
