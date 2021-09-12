<?php

namespace EsUtils;

use ArrayAccess;
use Countable;
use Iterator;

class Collection implements ArrayAccess, Countable, Iterator
{
    /**
     * The items contained the collection
     * @var array
     */
    protected $items;

    /**
     * @param array $items
     */
    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    /**
     * @param array $items
     * @return Collection
     */
    public static function init(array $items = []): Collection
    {
        return new self($items);
    }

    /**
     * @inheritDoc
     */
    public function offsetExists($offset): bool
    {
        return isset($this->items[$offset]);
    }

    /**
     * @return mixed|null
     */
    public function first()
    {
        return $this->items[0] ?? null;
    }

    /**
     * @return mixed|null
     */
    public function last()
    {
        return end($this->items) ?? null;
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->items);
    }

    /**
     * @param $value
     */
    public function append($value)
    {
        $this->offsetSet(null, $value);
    }

    /**
     * @inheritDoc
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->items[] = $value;
        } else {
            $this->items[$offset] = $value;
        }
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset($offset)
    {
        unset($this->items[$offset]);
    }

    /**
     * @param $offset
     * @param $value
     */
    public function put($offset, $value)
    {
        $this->offsetSet($offset, $value);
    }

    /**
     * @param $key
     * @return mixed
     */
    public function get($key)
    {
        return $this->offsetGet($key);
    }

    /**
     * @inheritDoc
     */
    public function offsetGet($offset)
    {
        return $this->items[$offset];
    }

    /**
     * @inheritDoc
     */
    public function current()
    {
        return current($this->items);
    }

    /**
     * @inheritDoc
     */
    public function key()
    {
        return key($this->items);
    }

    /**
     * @inheritDoc
     */
    public function next()
    {
        return next($this->items);
    }

    /**
     * @inheritDoc
     */
    public function rewind()
    {
        return reset($this->items);
    }

    /**
     * @inheritDoc
     */
    public function valid(): bool
    {
        return key($this->items) !== null;
    }
}
