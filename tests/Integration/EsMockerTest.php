<?php

namespace Tests\Integration;

use BadMethodCallException;
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
            ->thenFail($failureMessage);

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

    /**
     * @test
     * @throws ElasticsearchException
     */
    public function it_should_allows_direct_failure()
    {
        $this->expectException(RequestException::class);

        $client = EsMocker::fail('Error message')->build();
        $client->info();
    }

    /**
     * @test
     */
    public function it_should_fail_with_invalid_static_calls()
    {
        $this->expectException(BadMethodCallException::class);
        EsMocker::invalidMethod();
    }
}
