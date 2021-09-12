<?php

namespace EsUtils;

use GuzzleHttp\Ring\Client\MockHandler as RingClientMockHandler;
use GuzzleHttp\Ring\Core;
use GuzzleHttp\Ring\Future\CompletedFutureArray;
use GuzzleHttp\Ring\Future\FutureArrayInterface;
use InvalidArgumentException;

class MockHandler extends RingClientMockHandler
{
    /**
     * Collection of transactions committed by this handler
     * @var Transaction[]|Collection
     */
    protected $transactions;

    /**
     * @var int
     */
    private $currentIndex;

    /**
     * @var bool;
     */
    private $isQueue;

    /**
     * @var Collection
     */
    private $results;

    /**
     * @param Collection $result
     */
    public function __construct(Collection $result)
    {
        parent::__construct([]);
        $this->results = $result;
        $this->transactions = new Collection();
        $this->currentIndex = 0;
        $this->isQueue = $this->isQueue($result);
    }

    /**
     * @param Collection $result
     * @return bool
     */
    private function isQueue(Collection $result): bool
    {
        if (!isset($result[0])) {
            return false;
        }

        return is_array($result[0]);
    }

    /**
     * @param array $request
     * @return CompletedFutureArray|FutureArrayInterface
     */
    public function __invoke(array $request)
    {
        $response = $this->invoke($request);

        $this->transactions->append(new Transaction());

        return $response;
    }

    /**
     * @param $request
     * @return CompletedFutureArray|FutureArrayInterface
     */
    private function invoke($request)
    {
        $result = $this->results->toArray();
        if ($this->isQueue) {
            $result = $this->results[$this->currentIndex++];
        }

        Core::doSleep($request);
        $response = is_callable($result)
            ? call_user_func($result, $request)
            : $result;

        if (is_array($response)) {
            $response = new CompletedFutureArray(
                $response + [
                    'status' => null,
                    'body' => null,
                    'headers' => [],
                    'reason' => null,
                    'effective_url' => null,
                ]
            );
        } elseif (!$response instanceof FutureArrayInterface) {
            throw new InvalidArgumentException(
                'Response must be an array or FutureArrayInterface. Found '
                . Core::describeType($request)
            );
        }

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
