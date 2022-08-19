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
    /**
     * @inheritDoc
     */
    public function __construct(
        $body = null,
        int $status = 200,
        array $headers = [Elasticsearch::HEADER_CHECK => Elasticsearch::PRODUCT_NAME],
        string $version = '1.1',
        string $reason = null
    ) {
        parent::__construct($status, $headers, $body, $version, $reason);
    }
}
