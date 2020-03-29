<?php

namespace Camillebaronnet\ETL;

interface LoaderInterface
{
    public function __invoke(iterable $line);
}
