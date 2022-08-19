<?php

namespace EsUtils;

use BadMethodCallException;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class EsMocker
 * This class is used to mock responses for Elasticsearch requests.
 *
 * @method static EsMocker mock(array $body, int $statusCode = 200)
 * @method static EsMocker fail(string $message)
 */
class EsMocker
{
    /**
     * @var ResponseInterface[]|ClientExceptionInterface[]
     */
    private array $mockResponses = [];

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
    public function thenFail(string $string): EsMocker
    {
        $requestException = new RequestException($string);
        $this->mockResponses[] = $requestException;

        return $this;
    }

    /**
     * Builds a client that uses the mocked responses.
     * @throws AuthenticationException
     */
    public function build(array &$transactions = []): Client
    {
        $httpClient = HttpClientFactory::mock($this->mockResponses, $transactions);

        return ClientBuilder::create()->setHttpClient($httpClient)->build();
    }

    /**
     * @param $name
     * @param $arguments
     *
     * @return EsMocker
     */
    public static function __callStatic($name, $arguments): EsMocker
    {
        $staticMethods = ['mock', 'fail'];

        if (! in_array($name, $staticMethods)) {
            throw new BadMethodCallException(sprintf('Method %s does not exist', $name));
        }

        $esMocker = new self();

        if ($name === 'mock') {
            $esMocker->then(...$arguments);
        } else {
            $esMocker->thenFail(...$arguments);
        }

        return $esMocker;
    }
}
