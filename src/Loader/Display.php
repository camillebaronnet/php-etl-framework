<?php

namespace Camillebaronnet\ETL\Loader;

use Generator;

class Display implements LoaderInterface, StreamLoaderInterface
{
    public function __invoke(array $data): void
    {
        print_r($data);
    }

    public function stream(Generator $collection): void
    {
        foreach ($collection as $row) {
            print_r($row);
        }
    }
}
