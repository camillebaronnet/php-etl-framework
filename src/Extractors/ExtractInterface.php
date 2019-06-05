<?php

namespace Camillebaronnet\ETL\Extractors;

interface ExtractInterface
{
    /**
     * @param array $params
     * @return iterable
     */
    public function __invoke(array $params = []): iterable;
}
