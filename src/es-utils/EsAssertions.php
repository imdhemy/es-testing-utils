<?php

namespace Imdhemy\EsUtils;

use GuzzleHttp\Psr7\Request;
use JsonException;
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
     * @param array<int, array<string, Request|mixed>> $history
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
            $expectedPath = "/$indexName";

            if ($path === $expectedPath && $transaction['request']->getMethod() === 'DELETE') {
                $requested = true;

                break;
            }
        }

        $this->assertTrue($requested);
    }

    /**
     * Asserts that history contains a request to PUT the given index mappings
     *
     * @param array<int, array<string, Request|mixed>> $history
     * @param string $indexName
     *
     * @return void
     */
    public function assertRequestedPutIndexMappings(array $history, string $indexName): void
    {
        $this->assertNotEmpty($history);
        $requested = false;

        foreach ($history as $transaction) {
            $path = $transaction['request']->getUri()->getPath();
            $expectedPath = '/' . $indexName . '/_mapping';

            if ($path === $expectedPath && $transaction['request']->getMethod() === 'PUT') {
                $requested = true;

                break;
            }
        }

        $this->assertTrue($requested);
    }

    /**
     * Asserts that history contains a request to PUT the given index mappings
     *
     * @param array<int, array<string, Request|mixed>> $history
     * @param string $indexName
     * @param array $mappings
     *
     * @return void
     */
    public function assertRequestedPutIndexMappingsWith(array $history, string $indexName, array $mappings): void
    {
        $this->assertNotEmpty($history);
        $requested = false;

        foreach ($history as $transaction) {
            $request = $transaction['request'];
            $path = $request->getUri()->getPath();
            $expectedPath = '/' . $indexName . '/_mapping';

            if ($path === $expectedPath && $request->getMethod() === 'PUT') {
                $body = $request->getBody();
                $body->rewind();

                try {
                    $contents = json_decode($body->getContents(), true, 512, JSON_THROW_ON_ERROR);
                } catch (JsonException $e) {
                    continue;
                }

                if ($requested = ($contents === $mappings)) {
                    break;
                }
            }
        }

        $this->assertTrue($requested);
    }

    /**
     * Asserts that history contains a request to PUT the given index settings
     *
     * @param array<int, array<string, Request|mixed>> $history
     * @param string $indexName
     *
     * @return void
     */
    public function assertRequestedPutIndexSettings(array $history, string $indexName): void
    {
        $this->assertNotEmpty($history);
        $requested = false;

        foreach ($history as $transaction) {
            $path = $transaction['request']->getUri()->getPath();
            $expectedPath = '/' . $indexName . '/_settings';

            if ($path === $expectedPath && $transaction['request']->getMethod() === 'PUT') {
                $requested = true;

                break;
            }
        }

        $this->assertTrue($requested);
    }

    /**
     * Asserts that history contains a request to PUT the given index settings
     *
     * @param array<int, array<string, Request|mixed>> $history
     * @param string $indexName
     * @param array $settings
     *
     * @return void
     */
    public function assertRequestedPutIndexSettingsWith(array $history, string $indexName, array $settings): void
    {
        $this->assertNotEmpty($history);
        $requested = false;

        foreach ($history as $transaction) {
            $request = $transaction['request'];
            $path = $request->getUri()->getPath();
            $expectedPath = '/' . $indexName . '/_settings';

            if ($path === $expectedPath && $request->getMethod() === 'PUT') {
                $body = $request->getBody();
                $body->rewind();

                try {
                    $contents = json_decode($body->getContents(), true, 512, JSON_THROW_ON_ERROR);
                    $actualSettings = $contents['settings'] ?? null;
                } catch (JsonException $e) {
                    $actualSettings = null;
                    continue;
                }

                if ($requested = ($actualSettings === $settings)) {
                    break;
                }
            }
        }

        $this->assertTrue($requested);
    }

    /**
     * Asserts that history contains a request to create the given index
     *
     * @param array $history
     * @param string $indexName
     * @param array|null $settings
     * @param array|null $mappings
     *
     * @return void
     */
    public function assertRequestedCreateIndex(
        array $history,
        string $indexName,
        ?array $settings = null,
        ?array $mappings = null
    ): void {
        $this->assertNotEmpty($history);
        $expectedContents = [];

        if ($settings) {
            $expectedContents['settings'] = $settings;
        }

        if ($mappings) {
            $expectedContents['mappings'] = $mappings;
        }

        $requested = false;

        foreach ($history as $transaction) {
            $request = $transaction['request'];
            $path = $request->getUri()->getPath();
            $expectedPath = '/' . $indexName;

            if ($path === $expectedPath && $request->getMethod() === 'PUT') {
                $body = $request->getBody();
                $body->rewind();

                if (empty($expectedContents)) {
                    $requested = true;
                    break;
                }

                try {
                    $contents = json_decode($body->getContents(), true, 512, JSON_THROW_ON_ERROR);
                } catch (JsonException $e) {
                    $contents = null;
                    continue;
                }

                if ($expectedContents === $contents) {
                    $requested = true;
                    break;
                }
            }
        }

        $this->assertTrue($requested);
    }
}
