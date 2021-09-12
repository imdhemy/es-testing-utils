<?php

namespace EsUtils;

use GuzzleHttp\Ring\Client\MockHandler as RingClientMockHandler;
use GuzzleHttp\Ring\Future\CompletedFutureArray;
use GuzzleHttp\Ring\Future\FutureArrayInterface;

class MockHandler extends RingClientMockHandler
{
    /**
     * Collection of transactions committed by this handler
     * @var Transaction[]|Collection
     */
    protected $transactions;

    /**
     * @param $result
     */
    public function __construct($result)
    {
        parent::__construct($result);
        $this->transactions = new Collection();
    }

    /**
     * @param array $request
     * @return callable|CompletedFutureArray|FutureArrayInterface
     */
    public function __invoke(array $request)
    {
        $response = parent::__invoke($request);

        $this->transactions->append(new Transaction());

        return $response;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getTransactions(): Collection
    {
        return $this->transactions;
    }
}
