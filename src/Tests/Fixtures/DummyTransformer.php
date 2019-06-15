<?php

namespace Camillebaronnet\ETL\Tests\Fixtures;

use Camillebaronnet\ETL\Transformer\TransformInterface;

class DummyTransformer implements TransformInterface
{
    /**
     * {@inheritdoc}
     */
    public function __invoke(array $data, array $params = []): array
    {
        return $data;
    }
}
