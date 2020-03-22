<?php

namespace Camillebaronnet\ETL\Transformer;

class Flatten implements TransformInterface
{
    public $rootKey = '';

    public $glue = '.';

    public $ignore;

    public $only;

    /**
     * The class entry point.
     *
     * @param array $data
     * @return array
     */
    public function __invoke(array $data): array
    {

        $flattened = [];
        $this->flatten(
            $data,
            $flattened,
            $this->glue,
            $this->rootKey
        );

        return $flattened;
    }

    /**
     * Flatten recursively the data.
     *
     * @param array $input
     * @param array $result
     * @param string $glue
     * @param string $parentKey
     */
    private function flatten(array $input, array &$result, string $glue, string $parentKey = ''): void
    {

        foreach ($input as $key => $value) {
            $only = $this->only
                ? $this->stringStartBy($parentKey.$key, $this->only)
                : true;
            $ignore = $this->ignore
                ? !$this->stringStartBy($parentKey.$key, $this->ignore)
                : true;

            if (is_array($value) && $only && $ignore) {
                $this->flatten($value, $result, $glue, $parentKey.$key.$glue);
            } else {
                $result[$parentKey.$key] = $value;
            }
        }
    }

    /**
     * Check if the needle can be found on the haystack.
     *
     * @param $needle
     * @param array $haystack
     * @return bool
     */
    private function stringStartBy($needle, array $haystack): bool
    {
        foreach ($haystack as $input) {
            if (strpos($needle, $input) === 0) {
                return true;
            }
        }

        return false;
    }
}
