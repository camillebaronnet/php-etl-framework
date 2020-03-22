<?php

namespace Camillebaronnet\ETL\Strategy;

use Camillebaronnet\ETL\ETLInterface;
use Camillebaronnet\ETL\Exception\BadInterface;
use Camillebaronnet\ETL\Extractor\ExtractInterface;
use Camillebaronnet\ETL\Loader\StreamLoaderInterface;
use Camillebaronnet\ETL\Transformer\TransformInterface;
use Generator;

class StreamStrategy extends AbstractStrategy
{
    /**
     * @var ExtractInterface
     */
    private $extractor;

    /**
     * @var TransformInterface[]
     */
    private $transformers = [];

    /**
     * @return StreamStrategy
     * @throws BadInterface
     */
    public function extract(string $extractorClass, array $context = []): ETLInterface
    {
        $this->extractor = $this->instanceOfExtractor($extractorClass, $context);

        return $this;
    }

    /**
     * @return StreamStrategy
     * @throws BadInterface
     */
    public function transform(string $transformClass, array $context = []): ETLInterface
    {
        $this->transformers[] = $this->instanceOfTransform($transformClass, $context);

        return $this;
    }

    /**
     * @throws BadInterface
     */
    public function load(string $loadClass, ?array $context = [])
    {
        $load = new $loadClass;

        if(!$load instanceof StreamLoaderInterface){
            throw new BadInterface(sprintf('Bad interface. %s must be an instance of StreamLoaderInterface.', $loadClass));
        }

        $this->fillInstanceParameters($load, $context);
        $load->stream($this->stream());
    }

    /**
     * @return Generator
     */
    private function stream(): Generator
    {
        $extractor = $this->extractor;

        foreach($extractor() as &$row) {
            foreach ($this->transformers as $transformer) {
                $row = $transformer($row);
            }
            yield $row;
        }
    }
}
