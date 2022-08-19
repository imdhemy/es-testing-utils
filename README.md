# Elastic search testing utils

[![Tests](https://github.com/imdhemy/es-testing-utils/actions/workflows/tests.yml/badge.svg)](https://github.com/imdhemy/es-testing-utils/actions/workflows/tests.yml) [![Latest Stable Version](https://poser.pugx.org/imdhemy/es-testing-utils/v/stable)](https://packagist.org/packages/imdhemy/es-testing-utils) [![Total Downloads](https://poser.pugx.org/imdhemy/es-testing-utils/downloads)](https://packagist.org/packages/imdhemy/es-testing-utils)

Unit tests shouldn't depend on a running cluster, should be mocked out instead. To be more specific, the client
responses should be mocked out. Elastic search testing utils makes it super easy for you to mock Elasticsearch
responses.

## Installation

You can use composer

```
composer require --dev imdhemy/es-testing-utils
```

## Versions

| Elasticsearch | Es testing Utils                                            |
|---------------|-------------------------------------------------------------|
| 7.x           | [7.x](https://github.com/imdhemy/es-testing-utils/tree/7.x) |
| 8.x           | [8.x](https://github.com/imdhemy/es-testing-utils/tree/8.x) |

## Usage

Es testing utils provides you a fluent Elasticsearch mock builder, you can use it as follows:

```php
use EsUtils\EsMocker;

// Create ES client that returns the mock response
$client = EsMocker::mock(['tagline' => 'You know, for search.'])->build();

```

Or you can mock a sequence of responses:

```php
use EsUtils\EsMocker;

// The created client will return the `$info` response with the first request,
// and the `$search` response with the second request, and so on.
// Note: the `fail()` method mocks a request exception.
$client = EsMocker::mock($info)->then($index)->then($search)->fail($error)->build()

```

Below is a complete example of how to use EsMocker in a test:

```php
use EsUtils\EsMocker;

$expected=['tagline' => 'You know, for search.'];
$client = EsMocker::mock($expected)->build();

$response = $client->info();
$body = (string) $response->getBody();

$this->assertEquals(json_encode($expected), $body);
```

## Credits

- [Mohamad Eldhemy](https://imdhemy.com)
- [All Contributors](https://github.com/imdhemy/es-testing-utils/graphs/contributors)

## License

The ES testing utils is open-sourced software licensed under the [MIT license](/LICENSE)
