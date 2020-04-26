<?php

namespace Camillebaronnet\ETL\Transformer;

use Camillebaronnet\ETL\TransformInterface;
use RuntimeException;

class Map implements TransformInterface
{
    public $fields = [];

    public $keepUnmapped = false;

    /**
     * Use the value as renamed key if key is an integer.
     * @var bool
     */
    public $softKey = true;

    public function __invoke(iterable $data): iterable
    {
        $remappedData = [];

        foreach ($this->fields as $newKey => $originalKey) {
            $newKey = $this->softKey && is_int($newKey) ? $originalKey : $newKey;
            $remappedData[$newKey] = $data[$originalKey] ?? null;
        }

        if (!$this->keepUnmapped) {
            return $remappedData;
        }

        if(!is_array($data)){
            throw new RuntimeException('Input data must be an array.');
        }

        foreach (array_diff(array_keys($data), $this->fields) as $lostField) {
            $remappedData[$lostField] = $data[$lostField];
        }

        return $remappedData;
    }
}
