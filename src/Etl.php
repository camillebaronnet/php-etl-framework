<?php

namespace Camillebaronnet\ETL;

use Camillebaronnet\ETL\Exception\BadInterface;

class Etl implements ETLInterface
{
    /**
     * @var Step
     */
    private $extractor;

    /**
     * @var Step[]
     */
    private $steps = [];

    /**
     * @return Etl
     * @throws BadInterface
     */
    public function extract(string $extractorClass, array $arguments = []): ETLInterface
    {
        if (!is_subclass_of($extractorClass, ExtractInterface::class)) {
            throw new BadInterface(
                sprintf('Bad interface. %s must be an instance of ExtractInterface.', $extractorClass)
            );
        }

        $this->extractor = new Step($extractorClass, $arguments);

        return $this;
    }

    /**
     * @return Etl
     * @throws BadInterface
     */
    public function add(string $transformerOrLoaderClass, array $arguments = []): ETLInterface
    {
        if (
            !is_subclass_of($transformerOrLoaderClass, TransformInterface::class) &&
            !is_subclass_of($transformerOrLoaderClass, LoaderInterface::class)
        ) {
            throw new BadInterface(
                sprintf(
                    'Bad interface. %s must be an instance of TransformInterface or ItemLoaderInterface.',
                    $transformerOrLoaderClass
                )
            );
        }

        $this->steps[] = new Step($transformerOrLoaderClass, $arguments);

        return $this;
    }

    /**
     * @throws BadInterface
     */
    public function process(?string $loadClass = null, ?array $context = [])
    {
        if(null !== $loadClass){
            $this->add($loadClass, $context);
        }

        $this->run();
        $this->resetInstance();
    }

    private function run()
    {
        $iterate = static function ($data, Step $step){
            foreach($data as $row){
                if($step->getInstance() instanceof LoaderInterface){
                    $step->getInstance()($row);
                    yield $row;
                    continue;
                }

                $output = $step->getInstance()($row);
                if($output instanceof \Generator){
                    foreach($output as $line){
                        yield $line;
                    }
                } else {
                    yield $output;
                }
            }
        };

        $pipeline = static function($data) {
            foreach($data as $line){
                continue;
            }
        };

        $reversedSteps = array_reverse($this->steps);
        foreach($reversedSteps as $step){
            $next = clone $pipeline;

            $pipeline = static function($data) use ($iterate, $next, $step) {
                return $next($iterate($data, $step));
            };

        }

        $extractor = $this->extractor->getInstance();
        return $pipeline($extractor());
    }

    private function resetInstance(): void
    {
        foreach($this->steps as $instance){
            $instance->destroyInstance();
        }
    }
}
