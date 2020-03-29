<?php

namespace Camillebaronnet\ETL\Extractor;

use Camillebaronnet\ETL\Exception\MissingParameter;

class Http extends AbstractExtractor
{
    public $method = 'GET';
    public $url;
    public $data;
    public $curlOpts = [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_USERAGENT => '-',
        CURLOPT_AUTOREFERER => true,
        CURLOPT_SSL_VERIFYHOST => 2,
        CURLOPT_SSL_VERIFYPEER => true,
    ];

    /**
     * @throws MissingParameter
     */
    public function __invoke(): iterable
    {
        $this->requiredParameters(['url']);

        $curl_opts = [
            CURLOPT_URL => $this->url,
            CURLOPT_CUSTOMREQUEST => strtoupper($this->method),
        ];

        if (null !== $this->data) {
            $curl_opts += [
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $this->data,
            ];
        }

        if ('HEAD' === strtoupper($this->method)) {
            $curl_opts += [CURLOPT_NOBODY => 1];
        }

        $ch = curl_init();
        curl_setopt_array($ch, $curl_opts + $this->curlOpts);

        yield [
            'body' => curl_exec($ch),
            'contentType' => curl_getinfo($ch, CURLINFO_CONTENT_TYPE)
        ];

        curl_close($ch);
    }
}
