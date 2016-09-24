<?php

namespace cyrkulewski\PIdV\Validator;

/**
 * The personal identity number (Swedish: personnummer) is the Swedish national identification number.
 *
 * 10 digits and a hyphen with format YYMMDD-ZZZZ, where:
 * - YYMMDD correspond to the person's birthday. They are followed by a hyphen. People over the age of 100 replace the hyphen with a plus sign.
 * - ZZZZ are a serial number. An odd ninth number is assigned to males and an even ninth number is assigned to females.
 */
class SE extends AbstractValidator
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
        if (! $this->extractAndValidateDate($id)) {
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
     * @return int
     */
    private function calculateChecksum($id)
    {
        $checksum = 0;
        $onetwo = 1;
        for ($i = 0; $i < 9; $i++) {
            $onetwo = $onetwo == 1 ? 2 : 1;
            $tmp = $id[$i] * $onetwo;
            if ($tmp > 9) {
                $tmp = $tmp - 10 + 1;
            }
            $checksum += $tmp;
        }
        $checksum %= 10;
        if ($checksum != 0) {
            $checksum = 10 - $checksum;
        }
        return $checksum;
    }

    /**
     * @param string $id
     * @return bool
     */
    private function extractAndValidateDate($id)
    {
        return $this->validateDate(substr($id, 0, 6));
    }

    /**
     * @param string $date
     * @param string $format
     * @return bool
     */
    private function validateDate($date, $format = 'Ymd')
    {
        $date = $this->addCenturyToDate($date);
        $d = \DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    /**
     * @param string $date
     * @return string
     */
    private function addCenturyToDate($date)
    {
        $year = substr($date, 0, 2);
        $century = ($year <= date('y')) ? '20' : '19';
        return $century . $date;
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


}