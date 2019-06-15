<?php

namespace Camillebaronnet\ETL\Tests\Fixtures;

use Symfony\Component\Serializer\Encoder\DecoderInterface;

class DummyDecoder implements DecoderInterface
{
    /**
     * {@inheritdoc}
     */
    public function supportsDecoding($format)
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function decode($data, $format, array $context = [])
    {
        return $data;
    }
}
