<?php

namespace Camillebaronnet\ETL\Loader;

use Generator;

class Display implements LoaderInterface, StreamLoaderInterface
{
    /**
     * @param array $data
     * @param array $params
     * @return array
     */
    public function __invoke(array $data, array $params = [])
    {
        return print_r($data);
    }

    /**
     * @param Generator $collection
     * @param array $params
     * @return void
     */
    public function stream(Generator $collection, array $params = [])
    {
        foreach($collection as $row){
            print_r($row);
        }
    }
}
