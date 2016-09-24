<?php

namespace cyrkulewski\PIdV\Validator;

interface ValidatorInterface
{
    /**
     * @param string $id
     * @return bool
     */
    public function validate($id);

    /**
     * @return string
     */
    public function getName();
}