<?php

namespace Camillebaronnet\ETL\Transformer;

class Trim implements TransformInterface
{
    public function __invoke(array $data, array $params = []): array
    {
        return array_map('trim', $data);
    }
}
