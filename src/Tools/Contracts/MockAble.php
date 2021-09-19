<?php

namespace EsUtils\Tools\Contracts;

interface MockAble
{
    /**
     * Get the next template in queue order
     * @return TemplateAble
     */
    public function getNext(): TemplateAble;
}
