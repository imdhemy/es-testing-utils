<?php

namespace Imdhemy\Tests\Unit;

use Elastic\Elasticsearch\Response\Elasticsearch;
use Imdhemy\EsUtils\Response;
use Imdhemy\Tests\TestCase;

class ResponseTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_create_an_instance_of_guzzle_response(): void
    {
        $stub = new Response('{"message": "ok"}', 200, []);
        $this->assertInstanceOf(\GuzzleHttp\Psr7\Response::class, $stub);
    }

    /**
     * @test
     */
    public function it_should_add_es_product_headers(): void
    {
        $stub = new Response('{"message": "ok"}', 200, []);
        $headers = $stub->getHeaders();
        $this->assertArrayHasKey(Elasticsearch::HEADER_CHECK, $headers);
        $productName = $headers[Elasticsearch::HEADER_CHECK];
        $this->assertEquals([Elasticsearch::PRODUCT_NAME], $productName);
    }
}
