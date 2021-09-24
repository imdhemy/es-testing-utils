<?php

namespace EsUtils\Tools\Contracts;

/**
 * MockAble interface
 * Any class implements this interface can be handled by the mock handler
 */
interface MockAble
{
    /**
     * Get the next template in queue order
     * @return TemplateAble
     */
    public function getNext(): TemplateAble;
}
