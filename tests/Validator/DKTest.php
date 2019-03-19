<?php

namespace cyrkulewski\PIdV\Test\Validator;

use cyrkulewski\PIdV\Dictionary\CountryDictionary;
use cyrkulewski\PIdV\Validator\DK;

class DKTest extends \PHPUnit_Framework_TestCase
{
    public function test_validate_correctPersonalIDs()
    {
        $validator = new DK();
        $this->assertTrue($validator->validate('110674-1227'));
        $this->assertTrue($validator->validate('1106741227'));
    }

    public function test_validate_wrongPersonalIDs()
    {
        $validator = new DK();
        $this->assertFalse($validator->validate('150674-1227'));
        $this->assertFalse($validator->validate('1106941227'));
        $this->assertFalse($validator->validate('1106740000'));
        $this->assertFalse($validator->validate('11067400001'));
    }

    public function test_getName()
    {
        $validator = new DK();
        $this->assertEquals($validator->getName(), CountryDictionary::DENMARK);
    }
}
