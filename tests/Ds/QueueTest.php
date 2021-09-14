<?php

namespace Tests\Ds;

use EsUtils\Ds\Queue;
use PHPUnit\Framework\TestCase;

class QueueTest extends TestCase
{
    /**
     * @test
     */
    public function test_pop_removes_and_returns_the_value_at_the_front_of_the_queue()
    {
        $queue = new Queue();
        $this->assertNull($queue->pop());

        $queue = new Queue([0, 1, 3]);
        $this->assertEquals(0, $queue->pop());

        $this->assertEquals(2, $queue->count());
    }

    /**
     * @test
     */
    public function test_peek_returns_the_value_at_the_front_of_the_queue()
    {
        $queue = new Queue();
        $this->assertNull($queue->peek());

        $queue = new Queue([0, 1, 3]);
        $this->assertEquals(0, $queue->peek());
        $this->assertEquals(3, $queue->count());
    }

    /**
     * @test
     */
    public function test_push_pushes_value_into_the_queue()
    {
        $queue = new Queue();
        $this->assertNull($queue->peek());

        $queue->push(7);
        $this->assertEquals(7, $queue->peek());

        $queue->push(9);
        $this->assertEquals(7, $queue->peek());

        $this->assertEquals(7, $queue->pop());
        $this->assertEquals(9, $queue->peek());
        $this->assertEquals(9, $queue->pop());
    }

    /**
     * @test
     */
    public function test_is_empty()
    {
        $queue = new Queue();
        $this->assertTrue($queue->isEmpty());

        $queue->push(5);
        $this->assertFalse($queue->isEmpty());

        $queue->push(7);
        $this->assertEquals(5, $queue->peek());
        $queue->push(9);
        $queue->push(11);
        $this->assertFalse($queue->isEmpty());

        $queue->pop();
        $queue->pop();
        $this->assertFalse($queue->isEmpty());
        $queue->pop();
        $queue->pop();
        $this->assertTrue($queue->isEmpty());
    }
}
