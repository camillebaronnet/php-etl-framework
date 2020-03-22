<?php

namespace Camillebaronnet\ETL\Tests\Fixtures;

use Camillebaronnet\ETL\Extractor\ExtractInterface;

class DummyExtractor implements ExtractInterface
{
    public $data = [];

    /**
     * {@inheritdoc}
     */
    public function __invoke(): iterable
    {
        return $this->data;
    }
}
