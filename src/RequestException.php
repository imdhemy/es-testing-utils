<?php

namespace EsUtils;

class RequestException extends \GuzzleHttp\Exception\RequestException
{
    public function __construct(string $message, string $method = 'GET', string $path = '/_test', array $headers = [])
    {
        parent::__construct($message, new \GuzzleHttp\Psr7\Request($method, $path, $headers));
    }
}
