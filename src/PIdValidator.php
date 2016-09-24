<?php

namespace cyrkulewski\PIdV;

class PIdValidator
{

    public function validate($id, $country)
    {
        $validator = ValidatorFactory::create($country);
        return $validator->validate($id);
    }
}
