<?php

namespace Camillebaronnet\ETL\Loader;

use Generator;

interface StreamLoaderInterface
{
    /**
     * @param Generator $collection
     * @param array $context
     * @return void
     */
    public function stream(Generator $collection, array $context = []);
}
