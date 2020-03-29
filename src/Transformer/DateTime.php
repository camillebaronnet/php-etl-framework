<?php

namespace Camillebaronnet\ETL\Transformer;

use Camillebaronnet\ETL\TransformInterface;

class DateTime implements TransformInterface
{
    public $fields = [];
    public $from = 'Y-m-d H:i:s';
    public $to;

    public function __invoke(iterable $data): iterable
    {
        foreach($this->fields as $fieldName){
            $data[$fieldName] = \DateTime::createFromFormat(
                $this->from,
                $data[$fieldName]
            );

            if($this->to){
                $data[$fieldName] = $data[$fieldName]->format($this->to);
            }
        }

        return $data;
    }
}
