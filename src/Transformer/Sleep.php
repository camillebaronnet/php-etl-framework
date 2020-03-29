<?php

namespace Camillebaronnet\ETL\Transformer;

use Camillebaronnet\ETL\TransformInterface;

class Sleep implements TransformInterface
{
    public $seconds = 1;

    /**
     * The class entry point.
     */
    public function __invoke(iterable $data): iterable
    {
        usleep($this->seconds * 1000000);

        return $data;
    }
}
