<?php

namespace Camillebaronnet\ETL\Extractor;

use Camillebaronnet\ETL\Exception\MissingParameter;
use Camillebaronnet\ETL\ExtractInterface;

abstract class AbstractExtractor implements ExtractInterface
{
    /**
     * @param array $requiredFields
     * @throws MissingParameter
     */
    protected function requiredParameters(array $requiredFields): void
    {
        foreach ($requiredFields as $field) {
            if (null === $this->$field) {
                throw new MissingParameter('Parameter "'.$field.'" is missing.');
            }
        }
    }
}
