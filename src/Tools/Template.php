<?php

namespace EsUtils\Tools;

use EsUtils\Tools\Contracts\MockAble;
use EsUtils\Tools\Contracts\TemplateAble;

abstract class Template implements MockAble, TemplateAble
{
    /**
     * @var array
     */
    protected $body;

    /**
     * @var string
     */
    protected $effectiveUrl = 'localhost';

    /**
     * @var $headers
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
     * @inheritDoc
     */
    public function getNext(): TemplateAble
    {
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getBody(): ?array
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
     * @param mixed $headers
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
}
