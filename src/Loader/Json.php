<?php

namespace Camillebaronnet\ETL\Loader;

use Symfony\Component\Serializer\Encoder\JsonEncoder;

class Json implements LoaderInterface
{
    public $context = [];

    public function __invoke(array $data)
    {
        return (new JsonEncoder())->encode($data, JsonEncoder::FORMAT, $this->context);
    }
}
