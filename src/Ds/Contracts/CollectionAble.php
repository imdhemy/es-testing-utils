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
}
