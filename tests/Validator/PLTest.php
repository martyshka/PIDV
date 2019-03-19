<?php

namespace cyrkulewski\PIdV\Test\Validator;

use cyrkulewski\PIdV\Dictionary\CountryDictionary;
use cyrkulewski\PIdV\Validator\PL;

class PLTest extends \PHPUnit_Framework_TestCase
{
    public function test_validate_correctPersonalIDs()
    {
        $validator = new PL();
        $this->assertTrue($validator->validate('80011500014'));
        $this->assertTrue($validator->validate('800115-00014'));
        $this->assertTrue($validator->validate('90811500048'));
        $this->assertTrue($validator->validate('05301500220'));
        $this->assertTrue($validator->validate('08032900093'));
    }

    public function test_validate_wrongPersonalIDs()
    {
        $validator = new PL();
        $this->assertFalse($validator->validate('800115000149'));
        $this->assertFalse($validator->validate('90814000048'));
        $this->assertFalse($validator->validate('05991500220'));
        $this->assertFalse($validator->validate('bla'));
    }

    public function test_getName()
    {
        $validator = new PL();
        $this->assertEquals($validator->getName(), CountryDictionary::POLAND);
    }
}
