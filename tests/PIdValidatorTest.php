<?php

namespace cyrkulewski\PIdV\Test;

use cyrkulewski\PIdV\PIdValidator;

class PIdValidatorTest extends \PHPUnit_Framework_TestCase
{
    public function test_validate_correctPersonalIDs()
    {
        $validator = new PIdValidator();
        $this->assertTrue($validator->validate('197804188253', 'SE'));
        $this->assertTrue($validator->validate('201607292719', 'SE'));
    }

    public function test_validate_wrongPersonalIDs()
    {
        $validator = new PIdValidator();
        $this->assertFalse($validator->validate('7804180000', 'SE'));
        $this->assertFalse($validator->validate('201608292719', 'SE'));
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
