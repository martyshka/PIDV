<?php

namespace cyrkulewski\PIdV\Test;

use cyrkulewski\PIdV\PIdValidator;

class PIdValidatorTest extends \PHPUnit_Framework_TestCase
{
    public function test_validate_correctPersonalIDs()
    {
        $validator = new PIdValidator();
        $this->assertTrue($validator->validate('197704190011', 'SE'));
        $this->assertTrue($validator->validate('201509150080', 'SE'));
    }

    public function test_validate_wrongPersonalIDs()
    {
        $validator = new PIdValidator();
        $this->assertFalse($validator->validate('197704190000', 'SE'));
        $this->assertFalse($validator->validate('201509151180', 'SE'));
    }

    /**
     * @expectedException \Exception
     */
    public function test_validate_wrongCountry()
    {
        $validator = new PIdValidator();
        $validator->validate('0000', 'NOT-EXISTING-COUNTRY');
    }
}
