<?php

namespace Camillebaronnet\ETL\Tests\Transformer;

use Camillebaronnet\ETL\Transformer\Flatten;
use PHPUnit\Framework\TestCase;

final class FlattenTest extends TestCase
{
    /**
     * @var Flatten
     */
    private $flatten;

    /**
     * @var array
     */
    private $complexObject = [
        'name' => 'Bar',
        'address' => [
            'street' => '1 road',
            'zip' => 'xxx',
        ],
        'cards' => [
            ['name' => 'lo'],
            ['name' => 'lol'],
            ['name' => 'oll'],
        ],
        'sub-tree' => [
            'sub-key' => 'some value',
            're-sub-key' => 'another value',
        ],
    ];


    protected function setUp()
    {
        $this->flatten = new Flatten();
    }

    public function testCanFlattenObjectWithDefaultContext()
    {
        $result = $this->flatten->__invoke($this->complexObject);

        $this->assertEquals($result, [
            'name' => 'Bar',
            'address.street' => '1 road',
            'address.zip' => 'xxx',
            'cards.0.name' => 'lo',
            'cards.1.name' => 'lol',
            'cards.2.name' => 'oll',
            'sub-tree.sub-key' => 'some value',
            'sub-tree.re-sub-key' => 'another value',
        ]);
    }

    public function testCanFlattenOnlySomeSegments()
    {
        $result = $this->flatten->__invoke($this->complexObject, [
            'only' => ['address', 'sub-tree'],
        ]);

        $this->assertEquals($result, [
            'name' => 'Bar',
            'address.street' => '1 road',
            'address.zip' => 'xxx',
            'cards' => [
                ['name' => 'lo'],
                ['name' => 'lol'],
                ['name' => 'oll'],
            ],
            'sub-tree.sub-key' => 'some value',
            'sub-tree.re-sub-key' => 'another value',
        ]);
    }

    public function testCanFlattenAllSegmentsExceptOne()
    {
        $result = $this->flatten->__invoke($this->complexObject, [
            'ignore' => ['address'],
        ]);

        $this->assertEquals($result, [
            'name' => 'Bar',
            'address' => [
                'street' => '1 road',
                'zip' => 'xxx',
            ],
            'cards.0.name' => 'lo',
            'cards.1.name' => 'lol',
            'cards.2.name' => 'oll',
            'sub-tree.sub-key' => 'some value',
            'sub-tree.re-sub-key' => 'another value',
        ]);
    }

    public function testCanSpecifyACustomRootKey()
    {
        $result = $this->flatten->__invoke($this->complexObject, [
            'rootKey' => '__',
        ]);

        $this->assertEquals($result, [
            '__name' => 'Bar',
            '__address.street' => '1 road',
            '__address.zip' => 'xxx',
            '__cards.0.name' => 'lo',
            '__cards.1.name' => 'lol',
            '__cards.2.name' => 'oll',
            '__sub-tree.sub-key' => 'some value',
            '__sub-tree.re-sub-key' => 'another value',
        ]);
    }

    public function testCanSpecifyACustomGlue()
    {
        $result = $this->flatten->__invoke($this->complexObject, [
            'glue' => '_',
        ]);

        $this->assertEquals($result, [
            'name' => 'Bar',
            'address_street' => '1 road',
            'address_zip' => 'xxx',
            'cards_0_name' => 'lo',
            'cards_1_name' => 'lol',
            'cards_2_name' => 'oll',
            'sub-tree_sub-key' => 'some value',
            'sub-tree_re-sub-key' => 'another value',
        ]);
    }
}