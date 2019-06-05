<?php

namespace Camillebaronnet\ETL\Transformers;

class Rename implements TransformInterface
{
    public function __invoke(array $data, array $params = []): array
    {
        return array_map(static function($item) use ($params){
            foreach($params as $oldName => $newName){
                $item[$newName] = $item[$oldName];
                unset($item[$oldName]);
            }
            return $item;
        }, $data);
    }
}
