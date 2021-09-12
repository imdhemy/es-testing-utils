<?php

namespace Tests;

use Elasticsearch\ClientBuilder;
use EsUtils\MockHandler;

class MockHandlerTest extends TestCase
{
    /**
     * @test
     */
    public function test_it_returns_the_specified_body()
    {
        // Given
        $jsonFilePath = __DIR__ . '/fixtures/file.json';
        $result = [
            'status' => 200,
            'transfer_stats' => [
                'total_time' => 100
            ],
            'body' => fopen($jsonFilePath, 'r'),
            'effective_url' => 'localhost'
        ];
        $handler = new MockHandler($result);
        $client = ClientBuilder::create()->setHandler($handler)->build();

        // When
        $response = $client->info();

        // Then
        $expectedContent = json_decode(file_get_contents($jsonFilePath), true);
        $this->assertEquals($expectedContent, $response);
    }
}
