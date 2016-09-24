<?php

namespace cyrkulewski\PIdV\Validator;

/**
 * The Finish personal identity code (Finnish: henkilötunnus (HETU)
 *
 * It uses the form DDMMYYCZZZQ, where:
 * - DDMMYY is the date of birth,
 * - C is the century identification sign (+ for the 19th century, - for the 20th and A for the 21st),
 * - ZZZ is the personal identification number (odd number for males, even number for females),
 * - Q is a checksum character.
 */
class FI extends AbstractValidator
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
        if (! $this->extractAndValidateDate($id)) {
            return false;
        }
        return $this->calculateCheckSum($id) == substr($id, 10, 11);
    }

    /**
     * @param string $id
     * @return string
     */
    private function cleanFromIrrelevantSymbols($id)
    {
        $id = preg_replace('/[^0-9-+ABCDEFHJKLMNPRSTUVWXY]/', '', $id);
        return $id;
    }

    /**
     * @param string $id
     * @return bool
     */
    private function extractAndValidateDate($id)
    {
        return $this->validateDate(substr($id, 0, 6), substr($id, 6, 1));
    }

    /**
     * @param string $date
     * @param string $centurySymbol
     * @param string $format
     * @return bool
     */
    private function validateDate($date, $centurySymbol, $format = 'dmY')
    {
        $date = $this->addCenturyToDate($date, $centurySymbol);
        $d = \DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    /**
     * @param string $date
     * @param string $centurySymbol
     * @return string
     */
    private function addCenturyToDate($date, $centurySymbol)
    {
        switch ($centurySymbol) {
            case '-':
                $century = '19';
                break;
            case '+':
                $century = '18';
                break;
            default:
            case 'A':
                $century = '20';
        }
        return substr($date, 0, 4) . $century . substr($date, 4, 2);
    }

    /**
     * @param string $id
     * @return string
     */
    private function calculateCheckSum($id)
    {
        $id = preg_replace('/[^0-9]/', '', $id);
        $id = substr($id, 0, 9);
        $control = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
            'A', 'B', 'C', 'D', 'E', 'F', 'H', 'J', 'K', 'L',
            'M', 'N', 'P', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y');
        return $control[intval($id) % 31];
    }

}