<?php

namespace cyrkulewski\PIdV\Test\Validator;

use cyrkulewski\PIdV\Dictionary\CountryDictionary;
use cyrkulewski\PIdV\Validator\FI;

class FITest extends \PHPUnit_Framework_TestCase
{
    public function test_validate_correctPersonalIDs()
    {
        $validator = new FI();
        $this->assertTrue($validator->validate('311280-888Y'));
        $this->assertTrue($validator->validate('311280-999J'));
        $this->assertTrue($validator->validate('150190+027K'));
        $this->assertTrue($validator->validate('150113A0149'));
    }

    public function test_validate_wrongPersonalIDs()
    {
        $validator = new FI();
        $this->assertFalse($validator->validate('7804180000'));
        $this->assertFalse($validator->validate('201608292719'));
        $this->assertFalse($validator->validate('201608292719155'));
        $this->assertFalse($validator->validate('abcdef'));
        $this->assertFalse($validator->validate('197804318253'));
        $this->assertFalse($validator->validate('321280-888Y'));
    }

    public function test_getName()
    {
        $validator = new FI();
        $this->assertEquals($validator->getName(), CountryDictionary::FINLAND);
    }
}
