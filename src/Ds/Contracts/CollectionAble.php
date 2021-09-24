<?php

namespace EsUtils\Ds\Contracts;

use ArrayAccess;
use Countable;
use Iterator;

/**
 * Collection interface
 */
interface CollectionAble extends ArrayAccess, Iterator, Countable
{
    /**
     * Clears the collection items
     */
    public function clear(): void;

    /**
     * Checks if the collection is empty
     * @return bool
     */
    public function isEmpty(): bool;

    /**
     * Returns the array representation of the collection elements
     * @return array
     */
    public function toArray(): array;

    /**
     * Get first element of the collection
     * @return mixed
     */
    public function first();

    /**
     * Appends a new element to the collection
     * @param mixed $value
     */
    public function append($value): void;

    /**
     * Add a new element to the beginning of the collection
     * @param mixed $value
     */
    public function prepend($value): void;
}
