<?php

namespace Camillebaronnet\ETL\Tests\Fixtures;

use Camillebaronnet\ETL\Extractor\ExtractInterface;

class DummyExtractor implements ExtractInterface
{
    /**
     * {@inheritdoc}
     */
    public function __invoke(array $params = []): iterable
    {
        return $params['data'] ?? [];
    }
}
