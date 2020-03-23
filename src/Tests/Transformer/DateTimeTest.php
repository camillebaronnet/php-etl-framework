<?php

namespace Camillebaronnet\ETL\Tests\Transformer;

use Camillebaronnet\ETL\Transformer\DateTime;
use PHPUnit\Framework\TestCase;

final class DateTimeTest extends TestCase
{
    /**
     * @var DateTime
     */
    private $dateTime;

    /**
     * @var array
     */
    private $data = [
        'name' => 'Bar',
        'created_at' => '20/06/1990 12h15',
        'updated_at' => '21/06/2010 6h02',
    ];


    protected function setUp()
    {
        $this->dateTime = new DateTime();
    }

    public function testCanReformatTheDatesBySpecifyingInputFormatAndOutputFormat()
    {
        $this->dateTime->from = 'd/m/Y H\hi';
        $this->dateTime->to = 'Y-m-d H:i:s';
        $this->dateTime->fields = ['created_at', 'updated_at'];

        $result = $this->dateTime->__invoke($this->data);

        $this->assertEquals($result, [
            'name' => 'Bar',
            'created_at' => '1990-06-20 12:15:00',
            'updated_at' => '2010-06-21 06:02:00',
        ]);
    }
}
