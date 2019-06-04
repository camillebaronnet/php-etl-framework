<?php

namespace Camillebaronnet\ETL\Loader;

use Symfony\Component\Serializer\Encoder\JsonEncoder;

class Json implements LoaderInterface
{
    /**
     * @param array $data
     * @param array $params
     * @return array
     */
    public function __invoke(array $data, array $params = [])
    {
        return (new JsonEncoder())->encode($data, JsonEncoder::FORMAT, $params);
    }
}
