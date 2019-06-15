<?php

namespace Camillebaronnet\ETL\Tests\Fixtures;

use Camillebaronnet\ETL\Exception\BadInterface;
use Camillebaronnet\ETL\Exception\DecoderNotFound;
use Camillebaronnet\ETL\Extractor\Extension\SupportDecoders;

class SupportDecoderProxy
{
    use SupportDecoders;

    /**
     * @throws BadInterface
     * @throws DecoderNotFound
     */
    public function decodeHandler($body, $typeMime, $context)
    {
        return $this->decode($body, $typeMime, $context);
    }
}
