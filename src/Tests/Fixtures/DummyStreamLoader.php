<?php

namespace Camillebaronnet\ETL\Tests\Fixtures;

use Camillebaronnet\ETL\LoaderInterface;

class DummyStreamLoader implements LoaderInterface
{
    public $filename;

    public $lines = [];

    /**
     * Collect data during iterations.
     */
    public function __invoke(iterable $line)
    {
        $this->lines[] = $line;
    }

    /**
     * When the ETL process down, instance is instantly destruct.
     */
    public function __destruct()
    {
        if (null === $this->filename) {
            return;
        }

        file_put_contents($this->filename, serialize($this->lines));
    }
}
