<?php

namespace Camillebaronnet\ETL\Transformers;

interface TransformInterface
{
    /**
     * @param array $params
     * @param array $params
     * @return array
     */
    public function __invoke(array $data, array $params = []): array;
}
