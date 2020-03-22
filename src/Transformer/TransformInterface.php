<?php

namespace Camillebaronnet\ETL\Transformer;

interface TransformInterface
{
    public function __invoke(array $data): array;
}
