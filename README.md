# Elastic search testing utils

[![Tests](https://github.com/imdhemy/es-testing-utils/actions/workflows/tests.yml/badge.svg)](https://github.com/imdhemy/es-testing-utils/actions/workflows/tests.yml) [![Latest Stable Version](https://poser.pugx.org/imdhemy/es-testing-utils/v/stable)](https://packagist.org/packages/imdhemy/es-testing-utils) [![Total Downloads](https://poser.pugx.org/imdhemy/es-testing-utils/downloads)](https://packagist.org/packages/imdhemy/es-testing-utils)

Unit tests shouldn't depend on a running cluster, should be mocked out instead. To be more specific, the client
responses should be mocked out. Elastic search testing utils makes it super easy for you to mock Elasticsearch
responses.

## Installation

You can use composer

```
composer require --dev imdhemy/es-testing-utils "^7"
```

## Versions

| Elasticsearch | Es testing Utils |
| --- | --- |
| 7.x | 7.x |

## Usage

At first prepare your template instance

```php
use EsUtils\Tools\Template;

$template = new Template()
$template->setBody(['tagline' => 'You Know, for Search']);
```

Then create an instance of the template mock handler

```php
use EsUtils\Tools\TemplateMockHandler;

$mockHandler = new TemplateMockHandler($template);
```

Finally, use the client builder to build your client.

```php
use Elasticsearch\ClientBuilder;

$builder = ClientBuilder::create();
$builder->setHandler($mockHandler);
$client = $builder->build();
```

Now, you can use this client on unit tests

```php
$response = $client->info();
$this->assertEquals($template->getBody(), $response);
```

### Mocking a single response example

```php
use EsUtils\Tools\Template;
use EsUtils\Tools\TemplateMockHandler;
use Elasticsearch\ClientBuilder;

$template = new Template()
$template->setBody(['tagline' => 'You Know, for Search']);
$mockHandler = new TemplateMockHandler($template);

$client = ClientBuilder::create()->setHandler($mockHandler)->build();

$response = $client->info();
$this->assertEquals($template->getBody(), $response);
```

### Mocking a queue of responses

You can also mock a queue of responses to return in order.

```php
use EsUtils\Tools\Template;
use EsUtils\Tools\TemplateMockHandler;use EsUtils\Tools\TemplateQueue;

$firstTemplate = new Template();
$secondTemplate = new Template();

$mocks = new TemplateQueue();
$mocks->addTemplate($firstTemplate);
$mocks->addTemplate($secondTemplate);

$handler = new TemplateMockHandler($mocks);
// from now then, use the handler the same way of mocking a single response
```

## Credits

- [Mohamad Eldhemy](https://imdhemy.com)
- [All Contributors](https://github.com/imdhemy/es-testing-utils/graphs/contributors)

## License

The ES testing utils is open-sourced software licensed under the [MIT license](/LICENSE)
