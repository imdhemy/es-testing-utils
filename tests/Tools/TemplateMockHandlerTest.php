<?php

namespace Tests\Tools;

use EsUtils\Tools\Contracts\TransactionAble;
use EsUtils\Tools\TemplateMockHandler;
use EsUtils\Tools\TemplateQueue;
use PHPUnit\Framework\TestCase;
use Tests\Dummies\DummyTemplate;


class TemplateMockHandlerTest extends TestCase
{
    /**
     * @test
     */
    public function test_returns_array()
    {
        $template = new DummyTemplate();
        $mockHandler = new TemplateMockHandler($template);
        $response = $mockHandler([]);

        $this->assertEquals($template->getStatus(), $response['status']);
        $this->assertEquals($template->getHeaders(), $response['headers']);
        $this->assertEquals($template->getBody(), $response['body']);
        $this->assertEquals($template->getReason(), $response['reason']);
        $this->assertEquals($template->getEffectiveUrl(), $response['effective_url']);
    }

    /**
     * @test
     */
    public function test_it_records_transactions()
    {
        $template = new DummyTemplate();
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
        $templateOne = new DummyTemplate();
        $templateOne->setStatus(201);

        $templateTwo = new DummyTemplate();
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
}

