<?php

namespace Camillebaronnet\ETL\Loader;

use Camillebaronnet\ETL\LoaderInterface;

class DebugLoader implements LoaderInterface
{
    public function __invoke(iterable $line)
    {
        if(function_exists('dump')){
            dump($line);
        } else {
            var_dump($line);
        }
    }
}
