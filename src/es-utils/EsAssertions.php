<?php

namespace Imdhemy\EsUtils;

use GuzzleHttp\Psr7\Request;
use PHPUnit\Framework\TestCase;

/**
 * Elasticsearch assertions
 *
 * @mixin TestCase
 */
trait EsAssertions
{
    /**
     * Asserts that history contains a request to delete the given index
     *
     * @param array<int, array<string, Request>> $history
     * @param string $indexName
     *
     * @return void
     */
    public function assertRequestedDeleteIndex(array $history, string $indexName): void
    {
        $this->assertNotEmpty($history);
        $requested = false;

        foreach ($history as $transaction) {
            $path = $transaction['request']->getUri()->getPath();
            $expectedIndexName = trim($path, '/');

            if ($expectedIndexName === $indexName && $transaction['request']->getMethod() === 'DELETE') {
                $requested = true;

                break;
            }
        }

        $this->assertTrue($requested);
    }
}
