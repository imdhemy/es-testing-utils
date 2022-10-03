<?php

namespace Imdhemy\Tests\Unit;

use Faker\Generator;
use Imdhemy\EsUtils\Faker;
use Imdhemy\Tests\TestCase;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 */
class FakerTest extends TestCase
{
    /**
     * @var Faker
     */
    private Faker $sut;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->sut = Faker::create();
    }

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

    /**
     * @test
     * @psalm-suppress MixedAssignment
     */
    public function es_info(): void
    {
        $clusterUUID = $this->sut->uuid();
        $buildHash = $this->sut->md5();

        $expected = [
            'name' => 'es_utils',
            'cluster_name' => 'es-utils-cluster',
            'cluster_uuid' => $clusterUUID,
            'version' => [
                'number' => '8.4.2',
                'build_flavor' => 'default',
                'build_type' => 'mock',
                'build_hash' => $buildHash,
                'build_snapshot' => false,
                'lucene_version' => '9.3.0',
                'minimum_wire_compatibility_version' => '7.17.0',
                'minimum_index_compatibility_version' => '7.0.0',
            ],
            'tagline' => 'You Know, for Search',
        ];

        $this->assertEquals(
            $expected,
            $this->sut->esInfo([
                'cluster_uuid' => $clusterUUID,
                'version' => ['build_hash' => $buildHash],
            ])
        );
    }

    /**
     * @test
     */
    public function es_create_index(): void
    {
        $indexName = $this->sut->esIndex();

        $expected = [
            'acknowledged' => true,
            'shards_acknowledged' => true,
            'index' => $indexName,
        ];

        $this->assertEquals(
            $expected,
            $this->sut->esCreateIndex($indexName)
        );
    }
}
