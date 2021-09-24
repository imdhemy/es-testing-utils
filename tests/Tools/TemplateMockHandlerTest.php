<?php

namespace Tests\Tools;

use Elasticsearch\ClientBuilder;
use EsUtils\Tools\Contracts\TransactionAble;
use EsUtils\Tools\Template;
use EsUtils\Tools\TemplateMockHandler;
use EsUtils\Tools\TemplateQueue;
use PHPUnit\Framework\TestCase;

class TemplateMockHandlerTest extends TestCase
{
    /**
     * @test
     */
    public function test_returns_array()
    {
        $template = new Template();
        $mockHandler = new TemplateMockHandler($template);
        $response = $mockHandler([]);

        $expectedBody = stream_get_contents($template->getBodyStream());
        $actualBody = stream_get_contents($response['body']);

        $this->assertEquals($template->getStatus(), $response['status']);
        $this->assertEquals($template->getHeaders(), $response['headers']);
        $this->assertEquals($expectedBody, $actualBody);
        $this->assertEquals($template->getReason(), $response['reason']);
        $this->assertEquals($template->getEffectiveUrl(), $response['effective_url']);
    }

    /**
     * @test
     */
    public function test_it_records_transactions()
    {
        $template = new Template();
        $mockHandler = new TemplateMockHandler($template);

        $request = ['foo' => 'bar'];
        $mockHandler($request);

        $this->assertEquals(1, $mockHandler->getTransactions()->count());
        /** @var TransactionAble $transaction */
        $transaction = $mockHandler->getTransactions()->first();
        $this->assertSame($request, $transaction->getRequest());
        $this->assertSame($template, $transaction->getResponse());
    }

    /**
     * @test
     */
    public function test_it_mocks_template_queues()
    {
        $templateOne = new Template();
        $templateOne->setStatus(201);

        $templateTwo = new Template();
        $templateTwo->setStatus(404);

        $mocks = new TemplateQueue();
        $mocks->addTemplate($templateOne);
        $mocks->addTemplate($templateTwo);

        $mockHandler = new TemplateMockHandler($mocks);

        $response = $mockHandler([]);
        $this->assertEquals(1, $mockHandler->getTransactions()->count());
        $this->assertEquals($templateOne->getStatus(), $response['status']);

        $response = $mockHandler([]);
        $this->assertEquals($templateTwo->getStatus(), $response['status']);
        $this->assertEquals(2, $mockHandler->getTransactions()->count());
    }

    /**
     * @test
     */
    public function test_it_works_with_es_client()
    {
        $template = new Template();
        $mockHandler = new TemplateMockHandler($template);

        $clientBuilder = ClientBuilder::create();
        $clientBuilder->setHandler($mockHandler);

        $client = $clientBuilder->build();

        $response = $client->info();
        $this->assertIsArray($response);
        $this->assertEquals($template->getBody(), $response);
    }

    /**
     * @test
     */
    public function test_it_returns_the_same_body()
    {
        $template = new Template();
        $template->setBody(['foo' => 'bar']);
        $mockHandler = new TemplateMockHandler($template);

        $clientBuilder = ClientBuilder::create();
        $clientBuilder->setHandler($mockHandler);

        $client = $clientBuilder->build();

        $response = $client->info();
        $this->assertEquals($template->getBody(), $response);
    }
}
