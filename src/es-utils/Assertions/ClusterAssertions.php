<?php

namespace Imdhemy\EsUtils\Assertions;

use GuzzleHttp\Psr7\Request;
use PHPUnit\Framework\TestCase;

/**
 * Cluster assertions
 *
 * @mixin TestCase
 */
trait ClusterAssertions
{
    /**
     * Asserts that history contains a request to get the cluster info
     *
     * @param array<int, array<string, Request|mixed>> $history
     *
     * @return void
     */
    public function assertRequestedInfo(array $history): void
    {
        $this->assertNotEmpty($history);

        $requested = false;
        foreach ($history as $item) {
            $request = $item['request'];

            if ($request->getMethod() === 'GET' && $request->getUri()->getPath() === '/') {
                $requested = true;

                break;
            }
        }

        $this->assertTrue($requested);
    }
}
