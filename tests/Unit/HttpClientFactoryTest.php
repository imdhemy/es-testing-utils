<?php

namespace Imdhemy\Tests\Unit;

use GuzzleHttp\Psr7\Request;
use Imdhemy\EsUtils\HttpClientFactory;
use Imdhemy\EsUtils\Response;
use Imdhemy\Tests\TestCase;
use Psr\Http\Client\ClientExceptionInterface;

class HttpClientFactoryTest extends TestCase
{
    /**
     * @test
     * @throws ClientExceptionInterface
     */
    public function it_should_mock_a_single_response(): void
    {
        $response = new Response('{"message": "ok"}');

        $sut = HttpClientFactory::mock($response);

        $response = $sut->sendRequest(new Request('GET', 'test'));
        $this->assertEquals('{"message": "ok"}', (string)$response->getBody());
    }

    /**
     * @test
     * @throws ClientExceptionInterface
     */
    public function it_should_mock_multiple_responses(): void
    {
        $responses = [
            new Response('{"message": "ok"}'),
            new Response('{"message": "created"}'),
        ];

        $sut = HttpClientFactory::mock($responses);

        $response = $sut->sendRequest(new Request('GET', 'test'));
        $this->assertEquals('{"message": "ok"}', (string)$response->getBody());

        $response = $sut->sendRequest(new Request('GET', 'test'));
        $this->assertEquals('{"message": "created"}', (string)$response->getBody());
    }
}
