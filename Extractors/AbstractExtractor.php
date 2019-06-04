<?php

namespace Camillebaronnet\ETL\Extractors;

use Camillebaronnet\ETL\Exceptions\MissingParameter;

abstract class AbstractExtractor implements ExtractInterface
{
    /**
     * @param array $requiredFields
     * @param array $params
     * @throws MissingParameter
     */
    public function requiredParameters(array $requiredFields, array $params)
    {
        foreach($requiredFields as $field){
            if(!isset($params[$field])){
                throw new MissingParameter('Parameter "'.$field.'" is missing.');
            }
        }
    }
}