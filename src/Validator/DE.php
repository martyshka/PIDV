<?php

namespace cyrkulewski\PIdV\Validator;

/**
 * The personal identity number (German: Steueridentifikationsnummer) is the German national identification number.
 *
 * - 11 digits exactly
 * - first digit can not be 0
 * - the last digit is Checksum
 */
class DE extends AbstractValidator
{
    /**
     * @param string $id
     * @return bool
     */
    public function validate($id)
    {
        $id = $this->cleanFromIrrelevantSymbols($id);
        if (! $this->validateLength($id, 11)) {
            return false;
        }
        if ($this->isFirstDigitZero($id)) {
            return false;
        }
        if (! $this->isDigitsHasCorrectStats($id)) {
            return false;
        }
        return $this->calculateChecksum($id) == $id[strlen($id) - 1];
    }

    /**
     * @param string $id
     * @return string
     */
    private function cleanFromIrrelevantSymbols($id)
    {
        $id = preg_replace('/[^0-9]/', '', $id);
        return $id;
    }

    /**
     * @param string $id
     * @return bool
     */
    private function isFirstDigitZero($id)
    {
        return $id[0] == 0;
    }

    /**
     * @param string $id
     * @return bool
     */
    private function isDigitsHasCorrectStats($id)
    {
        $digits = str_split($id);
        array_pop($digits);
        $countDigits = array_count_values($digits);
        return (count($countDigits) != 9 && count($countDigits) != 8) ? false : true;
    }

    /**
     * @param string $id
     * @return int
     */
    private function calculateChecksum($id)
    {
        $product = 10;
        for ($i = 0; $i <= 9; $i++) {
            $sum = ($id[$i] + $product) % 10;
            if ($sum == 0) {
                $sum = 10;
            }
            $product = ($sum * 2) % 11;
        }
        $checksum = 11 - $product;
        return ($checksum == 10) ? 0 : $checksum;
    }
}