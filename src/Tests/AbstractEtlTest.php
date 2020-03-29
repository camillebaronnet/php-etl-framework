<?php

namespace Camillebaronnet\ETL\Tests;

use Camillebaronnet\ETL\ETLInterface;
use Camillebaronnet\ETL\Exception\BadInterface;
use Camillebaronnet\ETL\Tests\Fixtures\DummyExtractor;
use Camillebaronnet\ETL\Tests\Fixtures\DummyTransformer;
use PHPUnit\Framework\TestCase;
use stdClass;

abstract class AbstractEtlTest extends TestCase
{
    /**
     * @var ETLInterface
     */
    protected $etl;

    /**
     * @throws BadInterface
     */
    public function testCannotPassAnObjectThatDoesNotImplementExtractInterface()
    {
        $this->expectException(BadInterface::class);
        $this->etl->extract(stdClass::class);
    }

    /**
     * @throws BadInterface
     */
    public function testCannotPassAnObjectThatDoesNotImplementLoaderInterface()
    {
        $this->expectException(BadInterface::class);
        $this->etl->process(stdClass::class);
    }

    /**
     * @throws BadInterface
     */
    public function testCannotPassAnObjectThatDoesNotImplementTransformInterface()
    {
        $this->expectException(BadInterface::class);
        $this->etl->add(stdClass::class);
    }

    /**
     * @throws BadInterface
     */
    public function testCanPassAnObjectThatImplementExtractorInterface()
    {
        $etl = $this->etl->extract(DummyExtractor::class);
        $this->assertInstanceOf(ETLInterface::class, $etl);
    }

    /**
     * @throws BadInterface
     */
    public function testCanPassAnObjectThatImplementTransformerInterface()
    {
        $this->etl->extract(DummyExtractor::class);
        $etl = $this->etl->add(DummyTransformer::class);
        $this->assertInstanceOf(ETLInterface::class, $etl);
    }
}
