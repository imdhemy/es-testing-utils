<?php

namespace EsUtils\Tools\Contracts;

use EsUtils\Ds\Contracts\CollectionAble;
use GuzzleHttp\Ring\Future\CompletedFutureArray;

/**
 * Any template mock handler should implement this interface
 */
interface MockHandlerInterface
{
    /**
     * Gets all transactions handled by this mock handler
     * @return CollectionAble
     */
    public function getTransactions(): CollectionAble;

    /**
     * Allows the mock handler to be called as a function
     * @param array $request
     * @return CompletedFutureArray
     */
    public function __invoke(array $request): CompletedFutureArray;
}
