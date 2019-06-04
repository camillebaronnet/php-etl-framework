<?php

namespace Camillebaronnet\ETL\Loader;

interface LoaderInterface
{
    /**
     * @param array $collection
     * @param array $context
     * @return mixed
     */
    public function __invoke(array $collection, array $context = []);
}
