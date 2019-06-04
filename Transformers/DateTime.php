<?php

namespace Camillebaronnet\ETL\Transformers;

class DateTime implements TransformInterface
{
    const DEFAULT_FORMAT = 'Y-m-d H:i:s';

    public function __invoke(array $data, array $params = []): array
    {
        foreach($params['fields'] as $fieldName){
            $data[$fieldName] = \DateTime::createFromFormat(
                $params['format'] ?? static::DEFAULT_FORMAT,
                $data[$fieldName]
            );
        }

        return $data;
    }
}
