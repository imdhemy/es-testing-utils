<?php

namespace EsUtils\Tools;

use EsUtils\Tools\Contracts\TemplateAble;
use EsUtils\Tools\Contracts\TransactionAble;

class Transaction implements TransactionAble
{
    /**
     * @var array
     */
    private $request;

    /**
     * @var TemplateAble
     */
    private $response;

    /**
     * @param array $request
     * @param TemplateAble $response
     */
    public function __construct(array $request, TemplateAble $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @inheritDoc
     */
    public function getRequest(): array
    {
        return $this->request;
    }

    /**
     * @inheritDoc
     */
    public function getResponse(): TemplateAble
    {
        return $this->response;
    }
}
