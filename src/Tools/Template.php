<?php

namespace EsUtils\Tools;

use EsUtils\Tools\Contracts\MockAble;
use EsUtils\Tools\Contracts\TemplateAble;

class Template implements MockAble, TemplateAble
{
    /**
     * @var array
     */
    protected $body = [];

    /**
     * @var string
     */
    protected $effectiveUrl = 'localhost';

    /**
     * @var array
     */
    protected $headers = [];

    /**
     * @var string
     */
    protected $reason;

    /**
     * @var int
     */
    protected $status = 200;

    /**
     * @var array
     */
    protected $transferStats = ['total_time' => 100];

    /**
     * @inheritDoc
     */
    public function getNext(): TemplateAble
    {
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getBody(): array
    {
        return $this->body;
    }

    /**
     * @param array $body
     * @return Template
     */
    public function setBody(array $body): Template
    {
        $this->body = $body;

        return $this;
    }

    /**
     * @return resource
     */
    public function getBodyStream()
    {
        $jsonBody = json_encode($this->getBody());
        $encodedBody = base64_encode($jsonBody);
        $content = sprintf('data://text/plain;base64,%s', $encodedBody);
        return fopen($content, 'r');
    }

    /**
     * @inheritDoc
     */
    public function getEffectiveUrl(): ?string
    {
        return $this->effectiveUrl;
    }

    /**
     * @param string $effectiveUrl
     * @return Template
     */
    public function setEffectiveUrl(string $effectiveUrl): Template
    {
        $this->effectiveUrl = $effectiveUrl;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @param array $headers
     * @return Template
     */
    public function setHeaders(array $headers): Template
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getReason(): ?string
    {
        return $this->reason;
    }

    /**
     * @param string $reason
     * @return Template
     */
    public function setReason(string $reason): Template
    {
        $this->reason = $reason;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     * @return Template
     */
    public function setStatus(int $status): Template
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return array
     */
    public function getTransferStats(): array
    {
        return $this->transferStats;
    }

    /**
     * @param array $transferStats
     * @return Template
     */
    public function setTransferStats(array $transferStats): Template
    {
        $this->transferStats = $transferStats;

        return $this;
    }
}
