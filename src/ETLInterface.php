<?php

namespace Camillebaronnet\ETL;

use Camillebaronnet\ETL\Exceptions\BadInterface;

/**
 * Class ETL
 * @package Camillebaronnet\ETL
 */
interface ETLInterface
{
    /**
     * @param string $extractorClass
     * @param array $context
     * @return ETLInterface
     * @throws BadInterface
     */
    public function extract(string $extractorClass, array $context = []): self;

    /**
     * @param string $transformClass
     * @param array $context
     * @return ETLInterface
     * @throws BadInterface
     */
    public function transform(string $transformClass, array $context = []): self;

    /**
     * @param string $loadClass
     * @param array|null $context
     * @return mixed
     * @throws BadInterface
     */
    public function load(string $loadClass, array $context = []);
}
