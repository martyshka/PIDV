<?php

namespace cyrkulewski\PIdV\Test\Validator;

use cyrkulewski\PIdV\Validator\SE;

class SETest extends \PHPUnit_Framework_TestCase
{
    public function test_validate_correctPersonalIDs()
    {
        $validator = new SE();
        $this->assertTrue($validator->validate('197804188253'));
        $this->assertTrue($validator->validate('201607292719'));
        $this->assertTrue($validator->validate('20160729-2719'));
    }

    public function test_validate_wrongPersonalIDs()
    {
        $validator = new SE();
        $this->assertFalse($validator->validate('7804180000'));
        $this->assertFalse($validator->validate('201608292719'));
        $this->assertFalse($validator->validate('201608292719155'));
        $this->assertFalse($validator->validate('abcdef'));
        $this->assertFalse($validator->validate('197804318253'));
    }

    public function test_getName()
    {
        $validator = new SE();
        $this->assertEquals($validator->getName(), 'SE');
    }

}
