<?php

namespace Camillebaronnet\ETL\Strategy;

use Camillebaronnet\ETL\ETLInterface;
use Camillebaronnet\ETL\Exceptions\BadInterface;
use Camillebaronnet\ETL\Extractors\ExtractInterface;
use Camillebaronnet\ETL\Loader\StreamLoaderInterface;
use Camillebaronnet\ETL\Transformers\TransformInterface;
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
     * @var array
     */
    private $extractorContext = [];

    /**
     * @param string $extractorClass
     * @param array $context
     * @return StreamStrategy
     * @throws BadInterface
     */
    public function extract(string $extractorClass, array $context = []): ETLInterface
    {
        $this->extractor = $this->instanceOfExtractor($extractorClass);
        $this->extractorContext = $context;

        return $this;
    }

    /**
     * @param string $transformClass
     * @param array $context
     * @return StreamStrategy
     * @throws BadInterface
     */
    public function transform(string $transformClass, array $context = []): ETLInterface
    {
        $this->transformers[] = [
            'instance' => $this->instanceOfTransform($transformClass),
            'context' => $context
        ];

        return $this;
    }

    /**
     * @param string $loadClass
     * @param array|null $context
     * @throws BadInterface
     */
    public function load(string $loadClass, array $context = [])
    {
        $load = new $loadClass;

        if(!$load instanceof StreamLoaderInterface){
            throw new BadInterface(sprintf('Bad interface. %s must be an instance of StreamLoaderInterface.', $loadClass));
        }

        $load->stream($this->stream(), $context);
    }

    /**
     * @return Generator
     */
    private function stream(): Generator
    {
        $extractor = $this->extractor;

        foreach($extractor($this->extractorContext) as &$row) {
            foreach ($this->transformers as $transformer) {
                $row = $transformer['instance']($row, $transformer['context']);
            }
            yield $row;
        }
    }
}
