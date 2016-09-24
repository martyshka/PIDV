<?php

namespace cyrkulewski\PIdV\Validator;

/**
 * The Danish Personal Identification number (Danish: CPR-nummer or personnummer)
 *
 * 10 digits number with format DDMMYY-SSSS, where:
 * - DDMMYY is the date of birth
 * - SSSS is a sequence number.
 *
 * The first digit of the sequence number encodes the century of birth (so that centenarians are distinguished from infants),
 * and the last digit of the sequence number is odd for males and even for females.
 */
class DK extends AbstractValidator
{
    /**
     * @param string $id
     * @return bool
     */
    public function validate($id)
    {
        $id = $this->cleanFromIrrelevantSymbols($id);
        $id = $this->normalizeLength($id);
        if (! $this->validateLength($id, 10)) {
            return false;
        }

        return $this->calculateCheckSum($id) % 11 == 0;
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
     * @return string
     */
    private function normalizeLength($id)
    {
        if (strlen($id) > 10 && $id[0] <= 2) {
            $id = substr($id, 2);
        }
        return $id;
    }

    /**
     * @param string $id
     * @return int
     */
    private function calculateCheckSum($id)
    {
        $id = str_split($id);
        $factor = [4, 3, 2, 7, 6, 5, 4, 3, 2, 1];
        $checkSum = 0;
        for ($i = 0; $i <= 10; $i++) {
            $checkSum += $id[$i] * $factor[$i];
        }
        return $checkSum;
    }
}