<?php

namespace Camillebaronnet\ETL\Loader;

use Generator;

interface StreamLoaderInterface
{
    public function stream(Generator $collection): void;
}
