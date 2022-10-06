<?php

namespace Imdhemy\EsUtils;

use Faker\Factory;
use Faker\Generator;

/**
 * ES Utils Faker
 * This class is a wrapper for Faker\Generator
 *
 * @mixin Generator
 */
class Faker
{
    // Index names
    private const INDEX_NAMES = [
        'customers',
        'staffs',
        'orders',
        'stores',
        'categories',
        'products',
        'stocks',
        'brands',
        'payments',
        'invoices',
        'shipments',
        'returns',
        'reviews',
        'tags',
        'attributes',
        'users',
        'posts',
        'comments',
    ];

    /**
     * @var Generator
     */
    private Generator $generator;

    /**
     * @param Generator $generator
     */
    public function __construct(Generator $generator)
    {
        $this->generator = $generator;
    }

    /**
     * Creates a new Faker instance
     *
     * @param string $locale
     *
     * @return self
     */
    public static function create(string $locale = Factory::DEFAULT_LOCALE): self
    {
        return new self(Factory::create($locale));
    }

    /**
     * @param string $name
     * @param array $arguments
     *
     * @return mixed
     */
    public function __call(string $name, array $arguments)
    {
        return $this->generator->{$name}(...$arguments);
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function __get(string $name)
    {
        return $this->generator->{$name};
    }

    /**
     * @param string $name
     * @param mixed $value
     *
     * @return mixed
     */
    public function __set(string $name, $value)
    {
        return $this->generator->{$name} = $value;
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function __isset(string $name)
    {
        return isset($this->generator->{$name});
    }

    /**
     * Generates es cluster info
     *
     * @param array $info
     *
     * @return array
     */
    public function esInfo(array $info = []): array
    {
        $data = [
            'name' => 'es_utils',
            'cluster_name' => 'es-utils-cluster',
            'cluster_uuid' => $this->generator->uuid(),
            'version' => [
                'number' => '8.4.2',
                'build_flavor' => 'default',
                'build_type' => 'mock',
                'build_hash' => $this->generator->md5(),
                'build_snapshot' => false,
                'lucene_version' => '9.3.0',
                'minimum_wire_compatibility_version' => '7.17.0',
                'minimum_index_compatibility_version' => '7.0.0',
            ],
            'tagline' => 'You Know, for Search',
        ];

        return array_replace_recursive($data, $info);
    }

    /**
     * Generates es create index response
     *
     * @param string|null $indexName
     *
     * @return array
     */
    public function esCreateIndex(?string $indexName = null): array
    {
        $indexName = $indexName ?? $this->esIndex();

        return [
            'acknowledged' => true,
            'shards_acknowledged' => true,
            'index' => $indexName,
        ];
    }

    /**
     * Generates es index name
     *
     * @return string
     */
    public function esIndex(): string
    {
        return self::INDEX_NAMES[array_rand(self::INDEX_NAMES)];
    }

    /**
     * Generates es delete index response
     *
     * @return array
     */
    public function esDeleteIndex(): array
    {
        return $this->esAcknowledged();
    }

    /**
     * Generates es put index settings response
     *
     * @return array
     */
    public function esPutIndexSettings(): array
    {
        return $this->esAcknowledged();
    }

    /**
     * Generates es get index settings response
     *
     * @param string|null $index
     * @param array $settings
     *
     * @return array
     */
    public function esGetIndexSettings(?string $index = null, array $settings = []): array
    {
        $indexName = $index ?? $this->esIndex();
        $settings = array_replace_recursive([
            'routing' => [
                'allocation' => [
                    'include' => [
                        '_tier_preference' => 'data_content',
                    ],
                ],
            ],
            'number_of_shards' => '1',
            'provided_name' => $indexName,
            'creation_date' => $this->unixTime(),
            'number_of_replicas' => '1',
            'uuid' => $this->uuid(),
            'version' => [
                'created' => '8040299',
            ],
        ], $settings);

        return [
            $indexName => [
                'settings' => ['index' => $settings],
            ],
        ];
    }

    /**
     * Generate put index mappings response
     *
     * @return array
     */
    public function esPutIndexMappings(): array
    {
        return $this->esAcknowledged();
    }

    /**
     * Generates es acknowledged response
     *
     * @return array
     */
    public function esAcknowledged(): array
    {
        return [
            'acknowledged' => true,
        ];
    }
}
