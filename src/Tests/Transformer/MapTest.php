<?php

namespace Camillebaronnet\ETL\Tests\Transformer;

use Camillebaronnet\ETL\Transformer\Map;
use PHPUnit\Framework\TestCase;

final class MapTest extends TestCase
{
    /**
     * @var Map
     */
    private $map;

    /**
     * @var array
     */
    private $data = [
        'name' => 'Bar',
        'address_street' => '1 road',
        'address_zip' => 'xxx',
    ];


    protected function setUp()
    {
        $this->map = new Map();
    }

    public function testCanRenameSomeKeysAndRemoveUnrenamed()
    {
        $this->map->fields = [
            'TheName' => 'name',
        ];
        $result = $this->map->__invoke($this->data);

        $this->assertEquals([
            'TheName' => 'Bar'
        ], $result);
    }

    public function testCanRenameSomeKeysAndKeepUnrenamed()
    {
        $this->map->fields = [
            'TheName' => 'name',
        ];
        $this->map->keepUnmapped = true;
        $result = $this->map->__invoke($this->data);

        $this->assertEquals([
            'TheName' => 'Bar',
            'address_street' => '1 road',
            'address_zip' => 'xxx',
        ], $result);
    }

    public function testCanMapSomeKeysWithoutRenamesItAndRemoveOther()
    {
        $this->map->fields = ['name', 'address_street'];
        $result = $this->map->__invoke($this->data);

        $this->assertEquals([
            'name' => 'Bar',
            'address_street' => '1 road',
        ], $result);
    }
}
