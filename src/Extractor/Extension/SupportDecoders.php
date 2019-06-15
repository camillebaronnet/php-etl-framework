<?php

namespace Camillebaronnet\ETL\Extractor\Extension;

use Camillebaronnet\ETL\Exception\BadInterface;
use Camillebaronnet\ETL\Exception\DecoderNotFound;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\YamlEncoder;

trait SupportDecoders
{
    /**
     * Content-Type decoders matches.
     */
    protected static $TYPE_MIME_DECODERS = [
        'application/json' => JsonEncoder::class,
        'application/xml' => XmlEncoder::class,
        'text/yaml' => YamlEncoder::class,
        'text/x-yaml' => YamlEncoder::class,
        'application/yaml' => YamlEncoder::class,
        'text/vnd.yaml' => YamlEncoder::class,
        'application/x-yaml' => YamlEncoder::class,
        'text/csv' => CsvEncoder::class,
    ];

    /**
     * Content-Type extension decoders matches.
     */
    protected static $EXTENSIONS_DECODERS = [
        'json' => JsonEncoder::class,
        'xml' => XmlEncoder::class,
        'yaml' => YamlEncoder::class,
        'yml' => YamlEncoder::class,
        'csv' => CsvEncoder::class,
    ];

    /**
     * Extends the support of more type mime.
     *
     * @param $typeMime
     * @param $decoderClass
     * @throws BadInterface
     */
    public static function setTypeMimeDecoder($typeMime, $decoderClass): void
    {
        if (!new $decoderClass instanceof DecoderInterface) {
            throw new BadInterface(sprintf('%s must be an instance of DecoderInterface.', $decoderClass));
        }

        static::$TYPE_MIME_DECODERS[$typeMime] = $decoderClass;
    }

    /**
     * Extends the support for more extensions.
     *
     * @param $extension
     * @param $decoderClass
     * @throws BadInterface
     */
    public static function setExtensionDecoder($extension, $decoderClass): void
    {
        if (!new $decoderClass instanceof DecoderInterface) {
            throw new BadInterface(sprintf('%s must be an instance of DecoderInterface.', $decoderClass));
        }

        static::$EXTENSIONS_DECODERS[$extension] = $decoderClass;
    }

    /**
     * @param $contentType
     * @return null
     */
    protected function findDecoder($contentType)
    {
        preg_match('/^[^;]+/', $contentType, $matches);
        $contentType = trim($matches[0] ?? null);

        if (isset(static::$TYPE_MIME_DECODERS[$contentType])) {
            return static::$TYPE_MIME_DECODERS[$contentType];
        }

        preg_match('/\+([^+]+)$/', $contentType, $matches);
        $contentTypeExtension = $matches[1] ?? null;

        return static::$EXTENSIONS_DECODERS[$contentTypeExtension] ?? null;
    }

    /**
     * @param $body
     * @param $typeMime
     * @param array $context
     * @return mixed
     * @throws BadInterface
     * @throws DecoderNotFound
     */
    protected function decode($body, $typeMime, $context = [])
    {
        $contextDecoder = $context['decoder'] ?? [];
        $decoderClass = $contextDecoder['class'] ?? $this->findDecoder($typeMime);

        if (null === $decoderClass) {
            throw new DecoderNotFound;
        }

        $decoder = new $decoderClass;

        if (!$decoder instanceof DecoderInterface) {
            throw new BadInterface(sprintf('Bad interface. %s must be an instance of DecoderInterface.',
                $decoderClass));
        }

        $format = defined($decoderClass.'::FORMAT') ? $decoderClass::FORMAT : null;

        return $decoder->decode($body, $format, $context);
    }
}
