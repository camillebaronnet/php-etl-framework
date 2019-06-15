<?php

namespace Camillebaronnet\ETL\Exception;

use Exception;
use Throwable;

class DecoderNotFound extends Exception
{
    public function __construct(string $message = 'Decoder not found.', int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
