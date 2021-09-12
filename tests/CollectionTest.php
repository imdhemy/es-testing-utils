<?php

namespace Tests;


use EsUtils\Collection;

class CollectionTest extends TestCase
{
    /**
     * @test
     */
    public function test_it_is_countable()
    {
        $collection = Collection::init();
        $this->assertEquals(0, $collection->count());
        $this->assertEmpty($collection);
    }

    /**
     * @test
     */
    public function test_it_is_array_accessible()
    {
        $collection = Collection::init();
        $collection[] = 'foo';
        $this->assertEquals('foo', $collection[0]);
        $this->assertEquals('foo', $collection->get(0));

        $collection['foo'] = 'bar';
        $this->assertEquals('bar', $collection['foo']);
        $this->assertEquals('bar', $collection->get('foo'));
    }

    /**
     * @test
     */
    public function test_it_is_iterable()
    {
        $collection = Collection::init();
        $items = range(0, 100);
        foreach ($items as $item) {
            $collection[] = $item;
        }

        $actual = [];
        foreach ($collection as $item) {
            $actual[] = $item;
        }

        $this->assertEquals($items, $actual);
    }

    /**
     * @test
     */
    public function test_first()
    {
        $collection = Collection::init(range(0, 100));
        $this->assertEquals(0, $collection->first());
    }

    /**
     * @test
     */
    public function test_last()
    {
        $collection = Collection::init(range(0, 100));
        $this->assertEquals(100, $collection->last());
    }
}
