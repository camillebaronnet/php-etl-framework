<?php

namespace Camillebaronnet\ETL\Transformer;

class Sleep implements TransformInterface
{
    public $seconds = 1;

    /**
     * The class entry point.
     */
    public function __invoke(array $data): array
    {
        usleep($this->seconds * 1000000);

        return $data;
    }
}
