<?php

namespace Camillebaronnet\ETL\Extractor;

interface ExtractInterface
{
    /**
     * @param array $params
     * @return iterable
     */
    public function __invoke(array $params = []): iterable;
}
