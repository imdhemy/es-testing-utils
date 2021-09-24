<?php

namespace EsUtils\Tools\Contracts;

/**
 * Any mocked template should implement this interface
 */
interface TemplateAble
{
    /**
     * Returns response status code
     * @return int
     */
    public function getStatus(): int;

    /**
     * Returns response headers
     * @return array
     */
    public function getHeaders(): array;

    /**
     * Returns response body
     * @return array
     */
    public function getBody(): array;

    /**
     * Returns body as resource
     * @return resource
     */
    public function getBodyStream();

    /**
     * Returns reason
     * @return string|null
     */
    public function getReason(): ?string;

    /**
     * Returns effective URL
     * @return string|null
     */
    public function getEffectiveUrl(): ?string;

    /**
     * Returns transfer stats
     * @return array
     */
    public function getTransferStats(): array;
}
