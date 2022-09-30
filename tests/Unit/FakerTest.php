<?php

namespace Imdhemy\Tests\Unit;

use Faker\Generator;
use Imdhemy\EsUtils\Faker;
use Imdhemy\Tests\TestCase;

class FakerTest extends TestCase
{
    /**
     * @test
     */
    public function it_delegates_method_calls_to_faker(): void
    {
        $generatorMock = $this->createMock(Generator::class);
        $generatorMock->method('__call')
            ->willReturn('foo');

        $faker = new Faker($generatorMock);
        $this->assertEquals('foo', $faker->name());
    }

    /**
     * @test
     */
    public function it_delegates_property_calls_to_faker(): void
    {
        $generatorMock = $this->createMock(Generator::class);
        $generatorMock->method('__get')
            ->willReturn('foo');

        $faker = new Faker($generatorMock);
        $this->assertEquals('foo', $faker->name);
    }
}
