<?php

namespace Camillebaronnet\ETL\Extractor;

interface ExtractInterface
{
    public function __invoke(): iterable;
}
