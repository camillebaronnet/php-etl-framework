<?php

namespace Camillebaronnet\ETL\Transformer;

class Rename implements TransformInterface
{
    public $fields = [];

    public function __invoke(array $data): array
    {
        return array_map(function ($item) {
            foreach ($this->fields as $oldName => $newName) {
                $item[$newName] = $item[$oldName];
                unset($item[$oldName]);
            }
            return $item;
        }, $data);
    }
}
