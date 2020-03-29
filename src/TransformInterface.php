<?php

namespace Camillebaronnet\ETL;

/**
 * When a TransformInterface class return a Generator,
 * each yield is interpreted as a new line.
 */
interface TransformInterface
{
    public function __invoke(iterable $line): iterable;
}
