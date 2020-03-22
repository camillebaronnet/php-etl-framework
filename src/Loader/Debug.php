<?php

namespace Camillebaronnet\ETL\Loader;

use Generator;

class Debug implements LoaderInterface, StreamLoaderInterface
{
    public function __invoke(array $data)
    {
        return dump($data);
    }

    public function stream(Generator $collection): void
    {
        foreach ($collection as $row) {
            dump($row);
        }
    }
}
