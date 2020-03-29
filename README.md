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

This example extract some Github's repositories, apply some transformations

```php
<?php

use Camillebaronnet\ETL\Etl;
use Camillebaronnet\ETL\Extractor\Http;
use Camillebaronnet\ETL\Loader\DebugLoader;
use Camillebaronnet\ETL\Transformer\DateTime;
use Camillebaronnet\ETL\Transformer\Decode;
use Camillebaronnet\ETL\Transformer\Flatten;
use Camillebaronnet\ETL\Transformer\Map;
use Camillebaronnet\ETL\Transformer\Sleep;

$etl = (new Etl)
    ->extract(Http::class, ['url' => 'https://api.github.com/users/camillebaronnet/repos'])
    ->add(Decode::class)
    ->add(Sleep::class, ['seconds' => .2])
    ->add(Flatten::class, ['glue' => '_'])
    ->add(Map::class, [
        'fields' => [
            'id',
            'name',
            'full_name' => 'fullName',
            'owner_login' => 'ownerLogin',
            'owner_url' => 'ownerUrl',
            'url',
            'ssh_url' => 'sshUrl',
            'created_at' => 'createdAt'
        ]
    ])
    ->add(DateTime::class, [
        'fields' => ['createdAt'],
        'from' => 'Y-m-d\TH:i:s\Z',
        'to' => 'd/m/Y',
    ])
;

$etl->process(DebugLoader::class);

```

## The process explained

- **EXTRACT :**
Extract can output one or more items

- **TRANFORM :** 
A transform step takes the result of the previous 
step (extractor or transformer) apply an operation and optionally 
split the input into several subsets of items (example with [Decode](src/Transformer/Decode.php)).

- **LOADER :**
A loader can by placed at the end of the pipeline or between transformers.
Several Loader can be setting up.

## Collection

### Extractors

|Name |Description|
|------|------|
| [HTTP](src/Extractor/Http.php) | Simple wrapper for the libCurl |

### Transformers

|Name |Description|
|------|------|
| [Decode](src/Transformer/Decode.php) | Decode JSON, YAML, XML, CSV and more using Symfony's DecoderInterface |
| [Map](src/Transformer/Map.php) | Rename, keep and remove some fields |
| [Flatten](src/Transformer/Flatten.php) | Flattens a multi-dimensional collection into a single dimension |
| [Trim](src/Transformer/Trim.php) | Strip whitespace from the beginning and end of a string |
| [Sleep](src/Transformer/Sleep.php) | Delay execution |
| [DateTime](src/Transformer/DateTime.php) | Parse/Convert dates |


### Loaders

|Name |Description|
|------|------|
| [Debug](src/Loader/DebugLoader.php) | Display items in output |


## Extendable

You can easily create your own custom Extractors,
Transformers, Loader or Strategy by implementing the corresponding interface.

- [ExtractInterface](src/ExtractInterface.php)
- [TransformInterface](src/TransformInterface.php)
- [LoaderInterface](src/LoaderInterface.php)

Submit yours. Send a [pull-request](https://github.com/camillebaronnet/php-etl-framework/compare)
