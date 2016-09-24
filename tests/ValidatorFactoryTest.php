<?php

namespace cyrkulewski\PIdV\Test;

use cyrkulewski\PIdV\Validator\ValidatorInterface;
use cyrkulewski\PIdV\ValidatorFactory;

class ValidatorFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function test_create_correctInterface()
    {
        $this->assertInstanceOf(ValidatorInterface::class, ValidatorFactory::create('SE'));
    }

    /**
     * @expectedException \Exception
     */
    public function test_create_wrongClassNameRequested()
    {
        ValidatorFactory::create('NOT-EXISTING-COUNTRY-CODE');
    }
}
