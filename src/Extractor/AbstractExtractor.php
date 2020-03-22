<?php

namespace Camillebaronnet\ETL\Extractor;

use Camillebaronnet\ETL\Exception\MissingParameter;
use Camillebaronnet\ETL\Extractor\Extension\SupportDecoders;

abstract class AbstractExtractor implements ExtractInterface
{
    use SupportDecoders;

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
