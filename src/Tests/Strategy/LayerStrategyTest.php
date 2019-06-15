<?php

namespace Camillebaronnet\ETL\Tests\Strategy;

use Camillebaronnet\ETL\Strategy\LayerStrategy;
use Camillebaronnet\ETL\Exception\BadInterface;
use Camillebaronnet\ETL\Tests\Fixtures\DummyExtractor;
use Camillebaronnet\ETL\Tests\Fixtures\DummyLoader;
use Camillebaronnet\ETL\Tests\Fixtures\DummyTransformer;

final class LayerStrategyTest extends AbstractStrategyTest
{
    protected function setUp()
    {
        $this->etl = new LayerStrategy();
    }

    /**
     * @throws BadInterface
     */
    public function testCanPassAnObjectThatImplementLoaderInterface()
    {
        $this->etl->extract(DummyExtractor::class);
        $this->etl->transform(DummyTransformer::class);
        $return = $this->etl->load(DummyLoader::class);

        $this->assertEquals(
            [],
            $return
        );
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
        $return = $this->etl->load(DummyLoader::class);

        $this->assertEqualsCanonicalizing(
            $sample,
            $return
        );
    }
}
