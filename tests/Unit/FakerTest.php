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

    /**
     * @test
     */
    public function es_delete_index(): void
    {
        $expected = [
            'acknowledged' => true,
        ];

        $this->assertEquals(
            $expected,
            $this->sut->esDeleteIndex()
        );
    }

    /**
     * @test
     */
    public function put_index_settings(): void
    {
        $expected = [
            'acknowledged' => true,
        ];

        $this->assertEquals(
            $expected,
            $this->sut->putIndexSettings()
        );
    }

    /**
     * @test
     */
    public function es_get_index_settings(): void
    {
        $indexName = $this->sut->esIndex();
        $unixTime = $this->sut->unixTime;
        $uuid = $this->sut->uuid;

        $expected = [
            $indexName => [
                'settings' => [
                    'index' => [
                        'routing' => [
                            'allocation' => [
                                'include' => [
                                    '_tier_preference' => 'data_content',
                                ],
                            ],
                        ],
                        'number_of_shards' => '1',
                        'provided_name' => $indexName,
                        'creation_date' => $unixTime,
                        'number_of_replicas' => '1',
                        'uuid' => $uuid,
                        'version' => [
                            'created' => '8040299',
                        ],
                    ],
                ],
            ],
        ];

        $this->assertEquals(
            $expected,
            $this->sut->esGetIndexSettings($indexName, [
                'creation_date' => $unixTime,
                'uuid' => $uuid,
            ])
        );
    }
}
