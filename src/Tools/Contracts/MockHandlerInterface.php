<?php

namespace EsUtils\Tools\Contracts;

use EsUtils\Ds\Contracts\CollectionAble;
use GuzzleHttp\Ring\Future\CompletedFutureArray;

interface MockHandlerInterface
{
    /**
     * @return CollectionAble
     */
    public function getTransactions(): CollectionAble;

    /**
     * @param array $request
     * @return CompletedFutureArray
     */
    public function __invoke(array $request): CompletedFutureArray;
}
