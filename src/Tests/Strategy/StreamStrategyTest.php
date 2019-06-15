<?php

namespace Camillebaronnet\ETL\Tests\Strategy;

use Camillebaronnet\ETL\Strategy\StreamStrategy;
use Camillebaronnet\ETL\Exception\BadInterface;
use Camillebaronnet\ETL\Tests\Fixtures\DummyExtractor;
use Camillebaronnet\ETL\Tests\Fixtures\DummyStreamLoader;
use Camillebaronnet\ETL\Tests\Fixtures\DummyTransformer;
use Generator;

final class StreamStrategyTest extends AbstractStrategyTest
{
    private $tmpFile;

    protected function setUp()
    {
        $this->etl = new StreamStrategy();
        $this->tmpFile = tempnam(sys_get_temp_dir(), 'ETL');
    }

    /**
     * @throws BadInterface
     */
    public function testCanPassAnObjectThatImplementStreamLoaderInterface()
    {
        $this->etl->extract(DummyExtractor::class);
        $this->etl->transform(DummyTransformer::class);
        $this->etl->load(DummyStreamLoader::class);
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
        $this->etl->transform(DummyTransformer::class);
        $this->etl->load(DummyStreamLoader::class, ['filename' => $this->tmpFile]);

        $this->assertEqualsCanonicalizing(
            serialize($sample),
            file_get_contents($this->tmpFile)
        );
    }
}
