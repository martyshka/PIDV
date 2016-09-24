<?php

namespace cyrkulewski\PIdV;

use cyrkulewski\PIdV\Validator\ValidatorInterface;

class ValidatorFactory
{

    /**
     * @param string $country
     * @return ValidatorInterface
     * @throws \Exception
     */
    static public function create($country)
    {
        $validator = '\\cyrkulewski\\PIdV\\Validator\\' . $country;
        if (! class_exists($validator)) {
            throw new \Exception("Class '$validator' not found");
        }

        return new $validator();
    }

}