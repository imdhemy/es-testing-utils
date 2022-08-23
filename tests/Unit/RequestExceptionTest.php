<?php

namespace Tests\Unit;

use EsUtils\RequestException;
use Tests\TestCase;

class RequestExceptionTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_create_an_instance_of_guzzle_request_exception(): void
    {
        $stub = new RequestException('test');
        $this->assertInstanceOf(\GuzzleHttp\Exception\RequestException::class, $stub);
    }
}
