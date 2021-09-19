<?php

namespace EsUtils\Tools\Contracts;

use EsUtils\Ds\Contracts\CollectionAble;

interface MockHandlerInterface
{
    /**
     * @return CollectionAble
     */
    public function getTransactions(): CollectionAble;

    /**
     * @param array $request
     * @return array
     */
    public function __invoke(array $request): array;
}
