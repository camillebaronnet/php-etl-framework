<?php

namespace Camillebaronnet\ETL\Tests;

use Camillebaronnet\ETL\Etl;
use Camillebaronnet\ETL\Exception\BadInterface;
use Camillebaronnet\ETL\Tests\Fixtures\DummyExtractor;
use Camillebaronnet\ETL\Tests\Fixtures\DummyStreamLoader;
use Camillebaronnet\ETL\Tests\Fixtures\DummyTransformer;

final class ETLTest extends AbstractEtlTest
{
    private $tmpFile;

    protected function setUp()
    {
        $this->etl = new Etl();
        $this->tmpFile = tempnam(sys_get_temp_dir(), 'ETL');
    }

    /**
     * @throws BadInterface
     */
    public function testCanPassAnObjectThatImplementStreamLoaderInterface()
    {
        $this->etl->extract(DummyExtractor::class);
        $this->etl->add(DummyTransformer::class);
        $this->etl->process(DummyStreamLoader::class);
        $this->assertTrue(true);
    }

    /**
     * @throws BadInterface
     */
    public function testPipelineIsWorking()
    {
        $sample = [
            ['name' => 'foo', 'content' => 'Lorem'],
            ['name' => 'bar', 'content' => 'Ipsum']
        ];

        $this->etl->extract(DummyExtractor::class, ['data' => $sample]);
        $this->etl->add(DummyTransformer::class);
        $this->etl->process(DummyStreamLoader::class, ['filename' => $this->tmpFile]);

        $this->assertEqualsCanonicalizing(
            serialize($sample),
            file_get_contents($this->tmpFile)
        );
    }
}
