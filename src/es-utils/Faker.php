<?php

namespace Imdhemy\EsUtils;

use Faker\Generator;

/**
 * ES Utils Faker
 * This class is a wrapper for Faker\Generator
 *
 * @mixin Generator
 */
class Faker
{
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
}
