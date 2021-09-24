<?php

namespace EsUtils\Tools\Contracts;

/**
 * The transaction interface
 */
interface TransactionAble
{
    /**
     * Gets the request
     * @return array
     */
    public function getRequest(): array;

    /**
     * Gets the mocked response template
     * @return TemplateAble
     */
    public function getResponse(): TemplateAble;
}
