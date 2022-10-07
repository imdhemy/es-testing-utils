<?php

namespace Imdhemy\EsUtils\Assertions;

use PHPUnit\Framework\TestCase;

/**
 * Elasticsearch assertions
 *
 * @mixin TestCase
 */
trait EsAssertions
{
    use ClusterAssertions;
    use IndexAssertions;
}
