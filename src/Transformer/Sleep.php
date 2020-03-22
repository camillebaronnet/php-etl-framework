<?php

namespace Camillebaronnet\ETL\Transformer;

class Sleep implements TransformInterface
{
    public $seconds = 1;

    /**
     * The saved context, hydrated by the __invoke.
     *
     * @var array
     */
    protected $context = [];

    /**
     * The class entry point.
     */
    public function __invoke(array $data): array
    {
        sleep($this->seconds);

        return $data;
    }
}
