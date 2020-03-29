<?php

namespace Camillebaronnet\ETL;

use Camillebaronnet\ETL\Exception\BadInterface;

/**
 * Class ETL
 * @package Camillebaronnet\ETL
 */
interface ETLInterface
{
    /**
     * @return ETLInterface
     * @throws BadInterface
     */
    public function extract(string $extractorClass, array $context = []): self;

    /**
     * @return ETLInterface
     * @throws BadInterface
     */
    public function add(string $transformerOrLoaderClass, array $arguments = []): self;

    /**
     * @return mixed
     * @throws BadInterface
     */
    public function process(?string $loadClass = null, ?array $context = []);
}
