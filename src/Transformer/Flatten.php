<?php

namespace Camillebaronnet\ETL\Transformer;

class Flatten implements TransformInterface
{
    /**
     * Default context.
     */
    public const DEFAULT_CONTEXT = [
        'rootKey' => '',
        'glue' => '.',
        'ignore' => null,
        'only' => null,
    ];

    /**
     * The saved context, hydrated by the __invoke.
     *
     * @var array
     */
    protected $context = [];

    /**
     * The class entry point.
     *
     * @param array $data
     * @param array $context
     * @return array
     */
    public function __invoke(array $data, array $context = []): array
    {

        $context = $this->context = array_merge(static::DEFAULT_CONTEXT, $context);

        $flattened = [];
        $this->flatten(
            $data,
            $flattened,
            $context['glue'],
            $context['rootKey']
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
     * @param bool $escapeFormulas
     */
    private function flatten(array $input, array &$result, string $glue, string $parentKey = '')
    {

        foreach ($input as $key => $value) {
            $only = $this->context['only']
                ? $this->stringStartBy($parentKey.$key, $this->context['only'])
                : true;
            $ignore = $this->context['ignore']
                ? !$this->stringStartBy($parentKey.$key, $this->context['ignore'])
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
            if ($input === substr($needle, 0, strlen($input))) {
                return true;
            }
        }

        return false;
    }
}
