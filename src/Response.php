<?php

namespace EsUtils;

use Elastic\Elasticsearch\Response\Elasticsearch;
use GuzzleHttp\Psr7\Response as GuzzleResponse;

/**
 * Class Response
 * This class is a wrapper for GuzzleHttp\Psr7\Response.
 * It is used to mock the response of an Elasticsearch request.
 */
class Response extends GuzzleResponse
{
    public const ES_HEADERS = [Elasticsearch::HEADER_CHECK => Elasticsearch::PRODUCT_NAME];
    /**
     * This constructor receives body as the first parameter to make code more readable.
     *
     * @param string|null $body
     * @param int $status
     * @param array $headers
     */
    public function __construct(?string $body = null, int $status = 200, array $headers = [])
    {
        $headers = array_merge(self::ES_HEADERS, $headers);

        parent::__construct($status, $headers, $body);
    }
}
