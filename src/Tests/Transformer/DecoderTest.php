<?php

namespace Camillebaronnet\ETL\Tests\Strategy;

use Camillebaronnet\ETL\Exception\BadInterface;
use Camillebaronnet\ETL\Exception\DecoderNotFound;
use Camillebaronnet\ETL\Tests\Fixtures\DummyDecoder;
use Camillebaronnet\ETL\Transformer\Decode;
use PHPUnit\Framework\TestCase;

final class DecoderTest extends TestCase
{
    /**
     * @var Decode
     */
    private $extractor;

    protected function setUp()
    {
        $this->extractor = new Decode();
    }

    public function testExistingFormatCanByParsed()
    {
        $data = [['foo' => 'bar'], ['foo' => 'bar']];

        $decodedData = $this->extractor->__invoke([
            'body' => json_encode($data),
            'contentType' => 'application/json',
        ]);

        $this->assertEquals(iterator_to_array($decodedData), $data);
    }

    public function testUnknowFormatThrowsAnException()
    {
        $this->expectException(DecoderNotFound::class);
        $decodedData = $this->extractor->__invoke([
            'body' => '...',
            'contentType' => 'wingardium leviosa',
        ]);
        iterator_to_array($decodedData);
    }

    /**
     * @throws BadInterface
     * @throws DecoderNotFound
     */
    public function testExtendDecoderByPassingANewTypeMimeWorks()
    {
        $data = [['foo' => 'bar'], ['foo' => 'bar']];

        Decode::setTypeMimeDecoder('application/custom', DummyDecoder::class);
        $decodedData = $this->extractor->__invoke([
            'body' => $data,
            'contentType' => 'application/custom',
        ]);

        $this->assertEquals(iterator_to_array($decodedData), $data);
    }

    /**
     * @throws BadInterface
     * @throws DecoderNotFound
     */
    public function testExtendDecoderByPassingAnExtensionWorks()
    {
        $data = [['foo' => 'bar'], ['foo' => 'bar']];
        Decode::setExtensionDecoder('custom', DummyDecoder::class);
        $decodedData = $this->extractor->__invoke([
            'body' => $data,
            'contentType' => 'application/random+custom',
        ]);

        $this->assertEquals(iterator_to_array($decodedData), $data);
    }

    /**
     * @throws BadInterface
     * @throws DecoderNotFound
     */
    public function testCanForceDecoder()
    {
        $data = [['foo' => 'bar'], ['foo' => 'bar']];
        $this->extractor->forceDecoder = DummyDecoder::class;
        $decodedData = $this->extractor->__invoke([
            'body' => $data
        ]);

        $this->assertEquals(iterator_to_array($decodedData), $data);
    }

    /**
     * @throws BadInterface
     * @throws DecoderNotFound
     */
    public function testCanCustomizeParameters()
    {
        $data = [['foo' => 'bar'], ['foo' => 'bar']];

        $this->extractor->contentTypeField = 'type';
        $this->extractor->decodeFields = ['raw'];

        $decodedData = $this->extractor->__invoke([
            'raw' => $data,
            'type' => 'application/random+custom',
        ]);

        $this->assertEquals(iterator_to_array($decodedData), $data);
    }
}
