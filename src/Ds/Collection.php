<?php

namespace EsUtils\Ds;

use EsUtils\Ds\Contracts\CollectionAble;

/**
 * Collection class
 */
class Collection implements CollectionAble
{
    /**
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
     * @inheritDoc
     */
    public function clear(): void
    {
        $this->items = [];
    }

    /**
     * @param null $value
     */
    public function append($value): void
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
     * @inheritDoc
     */
    public function rewind()
    {
        reset($this->items);
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return $this->items;
    }

    /**
     * @inheritDoc
     */
    public function valid(): bool
    {
        return key($this->items) !== null;
    }

    /**
     * @param mixed $value
     */
    public function prepend($value): void
    {
        array_unshift($this->items, $value);
    }

    /**
     * @inheritDoc
     */
    public function count(): int
    {
        return count($this->items);
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
    public function isEmpty(): bool
    {
        return $this->count() === 0;
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
        next($this->items);
    }

    /**
     * @inheritDoc
     */
    public function offsetExists($offset): bool
    {
        return isset($this->items[$offset]);
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
    public function first()
    {
        return $this->items[0] ?: null;
    }
}
