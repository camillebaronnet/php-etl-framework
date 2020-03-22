<?php

namespace Camillebaronnet\ETL\Loader;

interface LoaderInterface
{
    public function __invoke(array $collection);
}
