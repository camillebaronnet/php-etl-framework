<?php

namespace Camillebaronnet\ETL;

use Camillebaronnet\ETL\Exception\BadInterface;
use Generator;

/**
 * Class ETL
 * @package Camillebaronnet\ETL
 */
interface ETLInterface
{
    /**
     * @throws BadInterface
     */
    public function extract(string $extractorClass, array $context = []): self;

    /**
     * @throws BadInterface
     */
    public function add(string $transformerOrLoaderClass, array $arguments = []): self;

    /**
     * @throws BadInterface
     */
    public function process(?string $loadClass = null, ?array $context = []);

    /**
     * @throws BadInterface
     */
    public function getIterator(): Generator;
}
