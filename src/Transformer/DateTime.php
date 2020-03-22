<?php

namespace Camillebaronnet\ETL\Transformer;

class DateTime implements TransformInterface
{
    public $fields = [];
    public $format = 'Y-m-d H:i:s';

    public function __invoke(array $data): array
    {
        foreach($this->fields as $fieldName){
            $data[$fieldName] = \DateTime::createFromFormat(
                $this->format,
                $data[$fieldName]
            );
        }

        return $data;
    }
}
