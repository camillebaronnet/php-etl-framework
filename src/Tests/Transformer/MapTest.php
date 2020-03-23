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
            'name' => 'TheName'
        ];
        $result = $this->map->__invoke($this->data);

        $this->assertEquals($result, [
            'TheName' => 'Bar'
        ]);
    }

    public function testCanRenameSomeKeysAndKeepUnrenamed()
    {
        $this->map->fields = [
            'name' => 'TheName'
        ];
        $this->map->keepUnmapped = true;
        $result = $this->map->__invoke($this->data);

        $this->assertEquals($result, [
            'TheName' => 'Bar',
            'address_street' => '1 road',
            'address_zip' => 'xxx',
        ]);
    }

    public function testCanMapSomeKeysWithoutRenamesItAndRemoveOther()
    {
        $this->map->fields = ['name', 'address_street'];
        $result = $this->map->__invoke($this->data);

        $this->assertEquals($result, [
            'name' => 'Bar',
            'address_street' => '1 road',
        ]);
    }
}
