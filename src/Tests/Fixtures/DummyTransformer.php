<?php

namespace Camillebaronnet\ETL\Tests\Fixtures;

use Camillebaronnet\ETL\TransformInterface;

class DummyTransformer implements TransformInterface
{
    /**
     * {@inheritdoc}
     */
    public function __invoke(iterable $data): iterable
    {
        return $data;
    }
}
