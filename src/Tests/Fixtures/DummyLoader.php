<?php

namespace Camillebaronnet\ETL\Tests\Fixtures;

use Camillebaronnet\ETL\Loader\LoaderInterface;

class DummyLoader implements LoaderInterface
{
    /**
     * {@inheritdoc}
     */
    public function __invoke(array $collection)
    {
        return $collection;
    }
}
