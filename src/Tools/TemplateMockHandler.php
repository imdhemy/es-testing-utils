<?php

namespace EsUtils\Tools;

use EsUtils\Ds\Collection;
use EsUtils\Ds\Contracts\CollectionAble;
use EsUtils\Tools\Contracts\MockAble;
use EsUtils\Tools\Contracts\MockHandlerInterface;
use GuzzleHttp\Ring\Core;
use GuzzleHttp\Ring\Future\CompletedFutureArray;

/**
 * The template mock handler
 */
class TemplateMockHandler implements MockHandlerInterface
{
    /**
     * @var MockAble
     */
    protected $mocks;

    /**
     * @var CollectionAble
     */
    protected $transactions;

    /**
     * @param MockAble $mocks
     */
    public function __construct(MockAble $mocks)
    {
        $this->mocks = $mocks;
        $this->transactions = new Collection();
    }

    /**
     * @inheritDoc
     */
    public function __invoke(array $request): CompletedFutureArray
    {
        Core::doSleep($request);

        $template = $this->mocks->getNext();
        $this->transactions->append(new Transaction($request, $template));

        $response = [
            'status' => $template->getStatus(),
            'transfer_stats' => $template->getTransferStats(),
            'headers' => $template->getHeaders(),
            'body' => $template->getBodyStream(),
            'reason' => $template->getReason(),
            'effective_url' => $template->getEffectiveUrl(),
        ];

        return new CompletedFutureArray($response);
    }

    /**
     * @inheritDoc
     */
    public function getTransactions(): CollectionAble
    {
        return $this->transactions;
    }
}
