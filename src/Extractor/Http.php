<?php

namespace Camillebaronnet\ETL\Extractor;

use Camillebaronnet\ETL\Exception\BadInterface;
use Camillebaronnet\ETL\Exception\MissingParameter;

class Http extends AbstractExtractor
{
    /**
     * Default context.
     */
    public const DEFAULT_CONTEXT = [
        'method' => 'GET',
        'data' => null,
        'headers' => [],
        'curl_opts' => [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_USERAGENT => '-',
            CURLOPT_AUTOREFERER => true,
            CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_SSL_VERIFYPEER => true,
        ],
    ];

    /**
     * @param array $context
     * @return iterable
     * @throws MissingParameter
     * @throws BadInterface
     */
    public function __invoke(array $context = []): iterable
    {
        $this->requiredParameters(['url'], $context);

        $context = array_merge(static::DEFAULT_CONTEXT, $context);
        $curl_opts = [
            CURLOPT_URL => $context['url'],
            CURLOPT_CUSTOMREQUEST => strtoupper($context['method']),
        ];

        if (null !== $context['data']) {
            $curl_opts += [
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $context['data'],
            ];
        }

        if ('HEAD' === strtoupper($context['method'])) {
            $curl_opts += [CURLOPT_NOBODY => 1];
        }

        $ch = curl_init();
        curl_setopt_array($ch, $curl_opts + $context['curl_opts']);
        $content = curl_exec($ch);
        $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
        curl_close($ch);

        return $this->decode(
            $content,
            $contentType,
            $context
        );
    }
}
