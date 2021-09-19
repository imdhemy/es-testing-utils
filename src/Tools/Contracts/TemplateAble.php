<?php

namespace EsUtils\Tools\Contracts;

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
     * @return array|null
     */
    public function getBody(): ?array;

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
}
