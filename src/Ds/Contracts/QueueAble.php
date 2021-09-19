<?php

namespace EsUtils\Ds\Contracts;

/**
 * A Queue is a “first in, first out” or “FIFO” collection
 */
interface QueueAble extends CollectionAble
{
    /**
     * Returns the value at the front of the queue
     * @return mixed
     */
    public function peek();

    /**
     * Removes and returns the value at the front of the queue
     * @return mixed
     */
    public function pop();

    /**
     * Pushes values into the queue
     * @param mixed $value
     */
    public function push($value): void;
}
