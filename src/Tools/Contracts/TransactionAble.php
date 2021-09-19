<?php

namespace EsUtils\Tools\Contracts;

interface TransactionAble
{
    /**
     * @return array
     */
    public function getRequest(): array;

    /**
     * @return TemplateAble
     */
    public function getResponse(): TemplateAble;
}
