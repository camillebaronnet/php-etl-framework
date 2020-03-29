<?php

namespace Camillebaronnet\ETL\Tests\Fixtures;

use Camillebaronnet\ETL\Loader\ItemLoaderInterface;

class DummyItemLoader implements ItemLoaderInterface
{
    /**
     * {@inheritdoc}
     */
    public function __invoke(array $collection)
    {
        return $collection;
    }
}
