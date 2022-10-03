<?php

namespace Imdhemy\EsUtils;

use BadMethodCallException;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use JsonException;
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
     *
     * @param array $body
     * @param int $statusCode
     *
     * @return EsMocker
     * @throws JsonException
     */
    public function then(array $body, int $statusCode = 200): EsMocker
    {
        $response = new Response(json_encode($body, JSON_THROW_ON_ERROR), $statusCode);
        $this->mockResponses[] = $response;

        return $this;
    }

    /**
     * Enqueues a request exception to be thrown when the next request is made.
     *
     * @param string $message
     *
     * @return $this
     */
    public function thenFail(string $message): EsMocker
    {
        $requestException = new RequestException($message);
        $this->mockResponses[] = $requestException;

        return $this;
    }

    /**
     * Builds a client that uses the mocked responses.
     */
    public function build(array &$transactions = []): Client
    {
        $httpClient = HttpClientFactory::mock($this->mockResponses, $transactions);

        return ClientBuilder::create()->setHttpClient($httpClient)->build();
    }

    /**
     * @param string $name
     * @param array $arguments
     *
     * @return EsMocker
     * @throws JsonException
     */
    public static function __callStatic(string $name, array $arguments): EsMocker
    {
        $staticMethods = ['mock', 'fail'];

        if (! in_array($name, $staticMethods, true)) {
            throw new BadMethodCallException(sprintf('Method %s does not exist', $name));
        }

        $esMocker = new self();

        if ($name === 'mock') {
            $esMocker->then((array)$arguments[0], (int)($arguments[1] ?? 200));
        } else {
            $esMocker->thenFail((string)$arguments[0]);
        }

        return $esMocker;
    }
}
