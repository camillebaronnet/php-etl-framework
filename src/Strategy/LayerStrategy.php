<?php

namespace Camillebaronnet\ETL\Strategy;

use Camillebaronnet\ETL\ETLInterface;
use Camillebaronnet\ETL\Exception\BadInterface;
use Camillebaronnet\ETL\Loader\LoaderInterface;

class LayerStrategy extends AbstractStrategy
{
    /**
     * @var array
     */
    private $data;

    /**
     * @return LayerStrategy
     * @throws BadInterface
     */
    public function extract(string $extractorClass, array $context = []): ETLInterface
    {
        $this->data = $this->instanceOfExtractor($extractorClass, $context)();

        return $this;
    }

    /**
     * @return ETLInterface
     * @throws BadInterface
     */
    public function transform(string $transformClass, array $context = []): ETLInterface
    {
        $transform = $this->instanceOfTransform($transformClass, $context);

        foreach($this->data as &$line){
            $line = $transform($line);
        }

        return $this;
    }

    /**
     * @return mixed
     * @throws BadInterface
     */
    public function load(string $loadClass, array $context = [])
    {
        $load = new $loadClass;

        if(!$load instanceof LoaderInterface){
            throw new BadInterface(sprintf('Bad interface. %s must be an instance of LoaderInterface.', $loadClass));
        }

        $this->fillInstanceParameters($load, $context);
        return $load($this->data);
    }
}
