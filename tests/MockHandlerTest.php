<?php

namespace Tests;

use Elasticsearch\ClientBuilder;
use EsUtils\Collection;
use EsUtils\MockHandler;

class MockHandlerTest extends TestCase
{
    /**
     * @test
     */
    public function test_it_returns_the_specified_body()
    {
        // Given
        $jsonFilePath = __DIR__ . '/fixtures/first-response.json';
        $result = [
            'status' => 200,
            'transfer_stats' => [
                'total_time' => 100
            ],
            'body' => fopen($jsonFilePath, 'r'),
            'effective_url' => 'localhost'
        ];
        $handler = new MockHandler(Collection::init($result));
        $client = ClientBuilder::create()->setHandler($handler)->build();

        // When
        $response = $client->info();

        // Then
        $expectedContent = json_decode(file_get_contents($jsonFilePath), true);
        $this->assertEquals($expectedContent, $response);
    }

    /**
     * @test
     */
    public function test_it_can_mock_multiple_responses()
    {
        $firstFilePath = __DIR__ . '/fixtures/first-response.json';
        $secondFilePath = __DIR__ . '/fixtures/second-response.json';

        $results = [
            [
                'status' => 200,
                'transfer_stats' => [
                    'total_time' => 100
                ],
                'body' => fopen($firstFilePath, 'r'),
                'effective_url' => 'localhost'
            ],
            [
                'status' => 200,
                'transfer_stats' => [
                    'total_time' => 100
                ],
                'body' => fopen($secondFilePath, 'r'),
                'effective_url' => 'localhost'
            ]
        ];

        $handler = new MockHandler(Collection::init($results));
        $client = ClientBuilder::create()->setHandler($handler)->build();

        $firstResponse = $client->info();
        $expectedResponse = json_decode(file_get_contents($firstFilePath), true);
        $this->assertEquals($expectedResponse, $firstResponse);

        $secondResponse = $client->info();
        $expectedResponse = json_decode(file_get_contents($secondFilePath), true);
        $this->assertEquals($expectedResponse, $secondResponse);
    }
}
