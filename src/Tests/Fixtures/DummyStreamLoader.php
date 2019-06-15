<?php

namespace Camillebaronnet\ETL\Tests\Fixtures;

use Camillebaronnet\ETL\Loader\StreamLoaderInterface;
use Generator;

class DummyStreamLoader implements StreamLoaderInterface
{
    /**
     * @param Generator $collection
     * @param array $context
     * @return Generator
     */
    public function stream(Generator $collection, array $context = [])
    {
        if(!isset($context['filename'])){
            return;
        }

        file_put_contents($context['filename'], serialize(iterator_to_array($collection)));
    }
}
