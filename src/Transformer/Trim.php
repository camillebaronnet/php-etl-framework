<?php

namespace Camillebaronnet\ETL\Transformer;

use Camillebaronnet\ETL\TransformInterface;

class Trim implements TransformInterface
{
    public function __invoke(array $data): array
    {
        return array_map('trim', $data);
    }
}
