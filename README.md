# Elastic search testing utils

[![Tests](https://github.com/imdhemy/es-testing-utils/actions/workflows/tests.yml/badge.svg)](https://github.com/imdhemy/es-testing-utils/actions/workflows/tests.yml) [![Latest Stable Version](https://poser.pugx.org/imdhemy/es-testing-utils/v/stable)](https://packagist.org/packages/imdhemy/es-testing-utils) [![Total Downloads](https://poser.pugx.org/imdhemy/es-testing-utils/downloads)](https://packagist.org/packages/imdhemy/es-testing-utils)

Unit tests shouldn't depend on a running cluster, should be mocked out instead.
To be more specific, the client
responses should be mocked out. Elastic search testing utils makes it super easy
for you to mock Elasticsearch
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

### Mocker

Es testing utils provides you a fluent Elasticsearch mock builder, you can use
it as follows:

```php
use Imdhemy\EsUtils\EsMocker;

// Create ES client that returns the mock response
$client = EsMocker::mock(['tagline' => 'You know, for search.'])->build();

```

Or you can mock a sequence of responses:

```php
use Imdhemy\EsUtils\EsMocker;

// The created client will return the `$info` response with the first request,
// and the `$search` response with the second request, and so on.
// Note: the `thenFail()` method mocks a request exception.
$client = EsMocker::mock($info)->then($index)->then($search)->thenFail($error)->build();

// Or you can directly fail the first request:
$client = EsMocker::fail($message)->build();

```

Below is a complete example of how to use EsMocker in a test:

```php
use Imdhemy\EsUtils\EsMocker;

$expected=['tagline' => 'You know, for search.'];
$client = EsMocker::mock($expected)->build();

$response = $client->info();
$body = (string) $response->getBody();

$this->assertEquals(json_encode($expected), $body);
```

### Faker

The faker class provides you a set of methods to generate random data for
your tests. It provides all the methods of the [Faker]() library along with
new methods to generate Elasticsearch data. All the methods related to
Elasticsearch starts with `es` prefix.

```php
use Imdhemy\EsUtils\Faker;

$faker = Faker::create();

$index = $faker->esIndexName(); // Returns a random index name
$createIndex = $faker->esCreateIndex(); // Returns create index response body

// Explore the Faker class to see all the available methods
```

## Credits

- [Mohamad Eldhemy](https://imdhemy.com)
- [All Contributors](https://github.com/imdhemy/es-testing-utils/graphs/contributors)

## License

The ES testing utils is open-sourced software licensed under
the [MIT license](/LICENSE)
