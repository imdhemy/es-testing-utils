<?php

namespace EsUtils\Tools;

use EsUtils\Ds\Collection;
use EsUtils\Ds\Contracts\CollectionAble;
use EsUtils\Tools\Contracts\MockAble;
use EsUtils\Tools\Contracts\MockHandlerInterface;
use GuzzleHttp\Ring\Core;

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
    public function __invoke(array $request): array
    {
        Core::doSleep($request);

        $template = $this->mocks->getNext();
        $this->transactions->append(new Transaction($request, $template));

        return [
            'status' => $template->getStatus(),
            'headers' => $template->getHeaders(),
            'body' => $template->getBody(),
            'reason' => $template->getReason(),
            'effective_url' => $template->getEffectiveUrl(),
        ];
    }

    /**
     * @inheritDoc
     */
    public function getTransactions(): CollectionAble
    {
        return $this->transactions;
    }
}
