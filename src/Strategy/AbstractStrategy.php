<?php

namespace Camillebaronnet\ETL\Strategy;

use Camillebaronnet\ETL\ETLInterface;
use Camillebaronnet\ETL\Exception\BadInterface;
use Camillebaronnet\ETL\Extractor\ExtractInterface;
use Camillebaronnet\ETL\Transformer\TransformInterface;

abstract class AbstractStrategy implements ETLInterface
{
    /**
     * @return ExtractInterface
     * @throws BadInterface
     */
    protected function instanceOfExtractor(string $extractorClass, array $params = []): ExtractInterface
    {
        $extractor = new $extractorClass;
        if (!$extractor instanceof ExtractInterface) {
            throw new BadInterface(sprintf('Bad interface. %s must be an instance of ExtractInterface.', $extractorClass));
        }

        return $this->fillInstanceParameters($extractor, $params);
    }

    /**
     * @return TransformInterface
     * @throws BadInterface
     */
    protected function instanceOfTransform(string $transformClass, array $params = []): TransformInterface
    {
        $transform = new $transformClass;
        if (!$transform instanceof TransformInterface) {
            throw new BadInterface(sprintf('Bad interface. %s must be an instance of TransformInterface.', $transformClass));
        }

        return $this->fillInstanceParameters($transform, $params);
    }

    protected function fillInstanceParameters($instance, array $params = [])
    {
        foreach($params as $field => $value){
            $instance->$field = $value;
        }

        return $instance;
    }
}
