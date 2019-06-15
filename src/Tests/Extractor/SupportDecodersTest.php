<?php

namespace Camillebaronnet\ETL\Tests\Strategy;

use Camillebaronnet\ETL\Exception\BadInterface;
use Camillebaronnet\ETL\Exception\DecoderNotFound;
use Camillebaronnet\ETL\Tests\Fixtures\DummyDecoder;
use Camillebaronnet\ETL\Tests\Fixtures\SupportDecoderProxy;
use PHPUnit\Framework\TestCase;

final class SupportDecodersTest extends TestCase
{
    /**
     * @var SupportDecoderProxy
     */
    private $extractor;

    protected function setUp()
    {
        $this->extractor = new SupportDecoderProxy();
    }

    /**
     * @throws BadInterface
     * @throws DecoderNotFound
     */
    public function testExistingFormatCanByParsed()
    {
        $data = ['foo' => 'bar'];

        $decodedData = $this->extractor->decodeHandler(
            json_encode($data),
            'application/json',
            []
        );

        $this->assertEquals($decodedData, $data);
    }

    /**
     * @throws BadInterface
     * @throws DecoderNotFound
     */
    public function testUnknowFormatThrowsAnException()
    {
        $this->expectException(DecoderNotFound::class);
        $this->extractor->decodeHandler(
            '...',
            'wingardium leviosa',
            []
        );
    }

    /**
     * @throws BadInterface
     * @throws DecoderNotFound
     */
    public function testExtendDecoderByPassingANewTypeMimeWorks()
    {
        $data = ['foo' => 'bar'];
        SupportDecoderProxy::setTypeMimeDecoder('application/custom', DummyDecoder::class);
        $decodedData = $this->extractor->decodeHandler(
            $data,
            'application/custom',
            []
        );

        $this->assertEquals($decodedData, $data);
    }

    /**
     * @throws BadInterface
     * @throws DecoderNotFound
     */
    public function testExtendDecoderByPassingAnExtensionWorks()
    {
        $data = ['foo' => 'bar'];
        SupportDecoderProxy::setExtensionDecoder('custom', DummyDecoder::class);
        $decodedData = $this->extractor->decodeHandler(
            $data,
            'application/random+custom',
            []
        );

        $this->assertEquals($decodedData, $data);
    }

    /**
     * @throws BadInterface
     * @throws DecoderNotFound
     */
    public function testForceDecoderByContextVariable()
    {
        $data = ['foo' => 'bar'];
        $decodedData = $this->extractor->decodeHandler(
            $data,
            'application/random+custom',
            [
                'decoder' => [
                    'class' => DummyDecoder::class,
                ],
            ]
        );

        $this->assertEquals($decodedData, $data);
    }
}
