<?php

namespace EsUtils\Ds;

use EsUtils\Ds\Contracts\QueueAble;

class Queue extends Collection implements QueueAble
{
    /**
     * @var int
     */
    private $head;

    /**
     * @param array $items
     */
    public function __construct(array $items = [])
    {
        parent::__construct($items);
        $this->head = 0;
    }

    /**
     * @inheritDoc
     */
    public function peek()
    {
        if ($this->isEmpty()) {
            return null;
        }

        return $this->items[$this->head];
    }

    /**
     * @inheritDoc
     */
    public function pop()
    {
        if ($this->isEmpty()) {
            return null;
        }

        $value = $this->items[$this->head];
        $this->offsetUnset($this->head);
        $this->head++;

        return $value;
    }

    /**
     * @inheritDoc
     */
    public function push($value): void
    {
        $this->offsetSet(null, $value);
    }
}
