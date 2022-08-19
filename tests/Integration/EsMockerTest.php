<?php

namespace Tests\Integration;

use Elastic\Elasticsearch\Exception\AuthenticationException;
use Elastic\Elasticsearch\Exception\ElasticsearchException;
use EsUtils\EsMocker;
use EsUtils\RequestException;
use PHPUnit\Framework\TestCase;

class EsMockerTest extends TestCase
{
    /**
     * @test
     * @throws ElasticsearchException
     */
    public function it_should_return_the_mocked_response()
    {
        $successBody = ['message' => 'ok'];
        $successStatusCode = 203;
        $createdBody = ['message' => 'created'];
        $createdStatusCode = 201;
        $failureMessage = 'Error communicating with Elasticsearch';

        $mocker = EsMocker::mock($successBody, $successStatusCode)
            ->then($createdBody, $createdStatusCode)
            ->fail($failureMessage);

        $client = $mocker->build();
        $successResponse = $client->info();
        $createdResponse = $client->index(['index' => 'my_index', 'body' => ['test_field' => 'abc']]);

        $successContent = (string)$successResponse->getBody();
        $this->assertEquals(json_encode($successBody), $successContent);

        $createdContent = (string)$createdResponse->getBody();
        $this->assertEquals(json_encode($createdBody), $createdContent);

        $this->expectException(RequestException::class);
        $this->expectExceptionMessage($failureMessage);
        $client->info();
    }

    /**
     * @test
     * @throws ElasticsearchException
     */
    public function it_should_allow_tracking_history()
    {
        $history = [];
        $client = EsMocker::mock(['message' => 'ok'])->then(['foo'])->build($history);

        $client->info();
        $client->info();

        $this->assertCount(2, $history);
    }
}
