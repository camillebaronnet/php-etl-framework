# ETL Framwork

Create simple imports with the [Extract, Transform, Load](https://en.wikipedia.org/wiki/Extract,_transform,_load) pattern.

[![Latest Stable Version](https://img.shields.io/packagist/v/camillebaronnet/php-etl.svg?style=flat-square)](https://packagist.org/packages/camillebaronnet/php-etl)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.1-8892BF.svg?style=flat-square)](https://php.net/)
[![GitHub issues](https://img.shields.io/github/issues/camillebaronnet/php-etl-framework.svg?style=flat-square)](https://github.com/camillebaronnet/php-etl-framework/issues)
[![GitHub license](https://img.shields.io/github/license/camillebaronnet/php-etl-framework.svg?style=flat-square)](https://github.com/camillebaronnet/php-etl-framework/blob/master/LICENSE)

## Installation

```sh
composer require camillebaronnet/php-etl
```

## Usage

```php
<?php

namespace App;

use Camillebaronnet\ETL\Extractor\Http;
use Camillebaronnet\ETL\Strategy\LayerStrategy;
use Camillebaronnet\ETL\Transformer\DateTime;
use Camillebaronnet\ETL\Loader\Json;
use Camillebaronnet\ETL\Transformer\Flatten;

//...

$etl = (new LayerStrategy)
    ->extract(Http::class, [
        'url' => 'https://api.github.com/users/camillebaronnet/repos'
    ])
    ->transform(Flatten::class, [
        'glue' => '_'
    ])
    ->transform(DateTime::class, ['format' => 'd/m/Y', 'fields' => ['createAt']])
;

echo $etl->load(Json::class);

//...
```

## The different strategies

<img src="docs/diagram.svg">

## Extendable

You can easily create your own custom Extractors,
Transformers, Loader or Strategy by implementing the corresponding interface.

- [ExtractInterface](src/Extractor/ExtractInterface.php)
- [TransformInterface](src/Transformer/TransformInterface.php)
- [LoaderInterface](src/Loader/LoaderInterface.php), if you're using the LayerStrategy.
- [StreamLoaderInterface](src/Loader/StreamLoaderInterface.php), if you're using the StreamStrategy.

You also can create a custom Strategy by implementing the [ETLInterface](src/ETLInterface.php).
