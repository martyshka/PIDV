<?php

namespace cyrkulewski\PIdV\Test\Validator;

use cyrkulewski\PIdV\Dictionary\CountryDictionary;
use cyrkulewski\PIdV\Validator\FR;

class FRTest extends \PHPUnit_Framework_TestCase
{
    public function test_validate_correctPersonalIDs()
    {
        $validator = new FR();
        $this->assertTrue($validator->validate('1231067890123'));
        $this->assertTrue($validator->validate('2820168756705'));
        $this->assertTrue($validator->validate('2822068756705'));
        $this->assertTrue($validator->validate('2400763757265'));
        $this->assertTrue($validator->validate('1500228756898'));
    }

    public function test_validate_wrongPersonalIDs()
    {
        $validator = new FR();
        $this->assertFalse($validator->validate('201608292719155'));
        $this->assertFalse($validator->validate('20160829'));
        $this->assertFalse($validator->validate('2820196756705'));
        $this->assertFalse($validator->validate('abcdef'));
        $this->assertFalse($validator->validate('240076375726a'));
        $this->assertFalse($validator->validate('4500228756898'));
    }

    public function test_getName()
    {
        $validator = new FR();
        $this->assertEquals($validator->getName(), CountryDictionary::FRANCE);
    }
}
