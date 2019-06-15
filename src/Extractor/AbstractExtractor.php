<?php

namespace Camillebaronnet\ETL\Extractor;

use Camillebaronnet\ETL\Exception\MissingParameter;
use Camillebaronnet\ETL\Extractor\Extension\SupportDecoders;

abstract class AbstractExtractor implements ExtractInterface
{
    use SupportDecoders;

    /**
     * @param array $requiredFields
     * @param array $params
     * @throws MissingParameter
     */
    protected function requiredParameters(array $requiredFields, array $params)
    {
        foreach ($requiredFields as $field) {
            if (!isset($params[$field])) {
                throw new MissingParameter('Parameter "'.$field.'" is missing.');
            }
        }
    }
}
