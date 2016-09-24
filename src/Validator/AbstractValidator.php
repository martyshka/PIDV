<?php

namespace cyrkulewski\PIdV\Validator;

abstract class AbstractValidator implements ValidatorInterface
{
    /**
     * Get the short name of the Validator
     *
     * @return string
     */
    public function getName()
    {
        return (new \ReflectionClass($this))->getShortName();
    }

    /**
     * @param string $id
     * @param int $expectedLength
     * @return bool
     */
    protected function validateLength($id, $expectedLength)
    {
        return (strlen($id) != $expectedLength) ? false : true;
    }
}