<?php

namespace cyrkulewski\PIdV\Test\Validator;

use cyrkulewski\PIdV\Dictionary\CountryDictionary;
use cyrkulewski\PIdV\Validator\DE;

class DETest extends \PHPUnit_Framework_TestCase
{
    public function test_validate_correctPersonalIDs()
    {
        $validator = new DE();
        $this->assertTrue($validator->validate('67624305982'));
        $this->assertTrue($validator->validate('12365489753'));
    }

    public function test_validate_wrongPersonalIDs()
    {
        $validator = new DE();
        $this->assertFalse($validator->validate('7804180000'));
        $this->assertFalse($validator->validate('02160829271'));
        $this->assertFalse($validator->validate('12345678912'));
        $this->assertFalse($validator->validate('201608292719155'));
        $this->assertFalse($validator->validate('abcdef'));
    }

    public function test_getName()
    {
        $validator = new DE();
        $this->assertEquals($validator->getName(), CountryDictionary::GERMANY);
    }
}
