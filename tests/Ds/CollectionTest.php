<?php

namespace Tests\Ds;

use EsUtils\Ds\Collection;
use PHPUnit\Framework\TestCase;

class CollectionTest extends TestCase
{
    /**
     * @test
     */
    public function test_clear_is_empty_and_count()
    {
        // Given
        $items = range(0, 9);
        $collection = new Collection($items);

        // When
        $collection->clear();

        // Then
        $this->assertTrue($collection->isEmpty());
        $this->assertEquals(0, $collection->count());
        $this->assertEmpty($collection);
    }

    /**
     * @test
     */
    public function test_offset_exists()
    {
        $items = ['foo' => 'bar'];
        $collection = new Collection($items);

        $this->assertTrue($collection->offsetExists('foo'));
        $this->assertFalse($collection->offsetExists('not-found-offset'));
    }

    /**
     * @test
     */
    public function test_offset_get()
    {
        $items = ['foo' => 'bar'];
        $collection = new Collection($items);

        $this->assertEquals('bar', $collection->offsetGet('foo'));
        $this->assertEquals('bar', $collection['foo']);
    }

    /**
     * @test
     */
    public function test_offset_set()
    {
        $collection = new Collection();
        $collection->offsetSet('foo', 'bar');

        $this->assertEquals('bar', $collection->offsetGet('foo'));
        $this->assertEquals('bar', $collection['foo']);
    }

    /**
     * @test
     */
    public function test_offset_unset()
    {
        $collection = new Collection(range(0, 9));
        $collection->offsetUnset(0);
        $this->assertArrayNotHasKey(0, $collection);
    }

    /**
     * @test
     */
    public function test_append()
    {
        $collection = new Collection();
        $collection->append(5);
        $collection->append(7);

        $this->assertEquals(5, $collection[0]);
        $this->assertEquals(5, $collection->offsetGet(0));

        $this->assertEquals(7, $collection[1]);
        $this->assertEquals(7, $collection->offsetGet(1));
    }

    /**
     * @test
     */
    public function test_prepend()
    {
        $collection = new Collection(range(1, 3));
        $collection->prepend(0);

        $this->assertEquals(0, $collection[0]);
        $this->assertEquals(0, $collection->offsetGet(0));
    }
}
