<?php

namespace Imdhemy\EsUtils;

use GuzzleHttp\Exception\RequestException as GuzzleException;
use GuzzleHttp\Psr7\Request;

/**
 * Class RequestException
 * This class is a wrapper for GuzzleHttp\Exception\RequestException.
 */
class RequestException extends GuzzleException
{
    /**
     * Constructor.
     *
     * @param string $message                         The exception message
     * @param string $method                          The HTTP method of the original request
     * @param string $path                            The path of the original request
     * @param array<string, string|string[]> $headers The headers of the original request
     */
    public function __construct(string $message, string $method = 'GET', string $path = '/_test', array $headers = [])
    {
        parent::__construct($message, new Request($method, $path, $headers));
    }
}
