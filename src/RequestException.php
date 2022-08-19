<?php

namespace EsUtils;

use GuzzleHttp\Psr7\Request;

class RequestException extends \GuzzleHttp\Exception\RequestException
{
    public function __construct(string $message, string $method = 'GET', string $path = '/_test', array $headers = [])
    {
        parent::__construct($message, new Request($method, $path, $headers));
    }
}
