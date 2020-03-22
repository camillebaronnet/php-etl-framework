<?php

namespace Camillebaronnet\ETL\Tests\Fixtures;

use Camillebaronnet\ETL\Loader\StreamLoaderInterface;
use Generator;

class DummyStreamLoader implements StreamLoaderInterface
{
    public $filename;

    public function stream(Generator $collection): void
    {
        if (null === $this->filename) {
            return;
        }

        file_put_contents($this->filename, serialize(iterator_to_array($collection)));
    }
}
