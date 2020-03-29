<?php

namespace Camillebaronnet\ETL\Transformer;

use Camillebaronnet\ETL\Exception\BadInterface;
use Camillebaronnet\ETL\Exception\DecoderNotFound;
use Camillebaronnet\ETL\TransformInterface;
use Generator;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\YamlEncoder;

/**
 * The Decoder transformer uses the Symfony's DecoderInterface classes to decode data.
 */
class Decode implements TransformInterface
{
    /**
     * Define which fields must be decoded.
     * @var array
     */
    public $decodeFields = ['body'];

    /**
     * Define which field contains the contentType information on the data set.
     * @var string
     */
    public $contentTypeField = 'contentType';

    /**
     * Force a DecoderInterface class instead of a smart decoding using the $contentTypeField.
     * @see DecoderInterface
     * @var
     */
    public $forceDecoder;

    /**
     * This is the context raw passed to the Symfony's DecoderInterface implementation.
     * @see DecoderInterface::decode()
     * @var array
     */
    public $context = [];

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
     * @throws BadInterface
     */
    public static function setTypeMimeDecoder(string $typeMime, string $decoderClass): void
    {
        if (!new $decoderClass instanceof DecoderInterface) {
            throw new BadInterface(sprintf('%s must be an instance of DecoderInterface.', $decoderClass));
        }

        static::$TYPE_MIME_DECODERS[$typeMime] = $decoderClass;
    }

    /**
     * @throws BadInterface
     */
    public static function setExtensionDecoder(string $extension, string $decoderClass): void
    {
        if (!new $decoderClass instanceof DecoderInterface) {
            throw new BadInterface(sprintf('%s must be an instance of DecoderInterface.', $decoderClass));
        }

        static::$EXTENSIONS_DECODERS[$extension] = $decoderClass;
    }

    /**
     * @return Generator
     * @throws BadInterface
     * @throws DecoderNotFound
     */
    public function __invoke(iterable $line): iterable
    {
        foreach($this->decodeFields as $field){
            $decoderClass = $this->forceDecoder ?? $this->findDecoder($line[$this->contentTypeField]);
            $line[$field] = $this->decode($line[$field], $decoderClass);

            foreach($line[$field] as $subsetItem){
                yield $subsetItem;
            }
        }
    }

    /**
     * @param mixed $data
     * @throws BadInterface
     * @throws DecoderNotFound
     */
    public function decode($data, ?string $decoderClass): iterable
    {
        if (null === $decoderClass) {
            throw new DecoderNotFound;
        }

        $decoder = new $decoderClass;

        if (!$decoder instanceof DecoderInterface) {
            throw new BadInterface(
                sprintf('Bad interface. %s must be an instance of DecoderInterface.', $decoderClass)
            );
        }

        $format = defined($decoderClass . '::FORMAT') ? $decoderClass::FORMAT : null;

        return $decoder->decode($data, $format, $this->context);
    }

    /**
     * @param $contentType
     * @return null
     */
    private function findDecoder($contentType)
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
}
