<?php

namespace Camillebaronnet\ETL\Strategy;

use Camillebaronnet\ETL\ETLInterface;
use Camillebaronnet\ETL\Exceptions\BadInterface;
use Camillebaronnet\ETL\Extractors\ExtractInterface;
use Camillebaronnet\ETL\Transformers\TransformInterface;

abstract class AbstractStrategy implements ETLInterface
{
    /**
     * @param string $extractorClass
     * @return ExtractInterface
     * @throws BadInterface
     */
    protected function instanceOfExtractor(string $extractorClass): ExtractInterface
    {
        $extractor = new $extractorClass;
        if(!$extractor instanceof ExtractInterface){
            throw new BadInterface(sprintf('Bad interface. %s must be an instance of ExtractInterface.', $extractorClass));
        }

        return $extractor;
    }

    /**
     * @param string $transformClass
     * @return TransformInterface
     * @throws BadInterface
     */
    protected function instanceOfTransform(string $transformClass): TransformInterface
    {
        $transform = new $transformClass;
        if(!$transform instanceof TransformInterface){
            throw new BadInterface(sprintf('Bad interface. %s must be an instance of TransformInterface.', $transformClass));
        }

        return $transform;
    }
}
