<?php

namespace Camillebaronnet\ETL\Transformers;

class Trim implements TransformInterface
{
    public function __invoke(array $data, array $params = []): array
    {
        return array_map('trim', $data);
    }
}
