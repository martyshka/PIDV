<?php

namespace cyrkulewski\PIdV\Validator;


/**
 * The Polish Personal Identification number PESEL.
 * (Polish: Powszechny Elektroniczny System Ewidencji Ludności, Universal Electronic System for Registration of the Population)
 *
 * 11 symbols number, has format YYMMDDZZZXQ, where:
 * - YYMMDD is the date of birth (with century encoded in month field),
 * - ZZZ is the personal identification number,
 * - X denotes sex (even for females, odd for males)
 * - Q is a control digit, which is used to verify whether given PESEL can be correct or not.
 */
class PL extends AbstractValidator
{
    /**
     * @var array
     */
    private $centuriesDictionary = array(
        'XIX'   => 18,
        'XX'    => 19,
        'XXI'   => 20,
        'XXII'  => 21,
        'XXIII' => 22,
    );

    /**
     * @var array
     */
    private $centuriesMonthIncreaser = array(
        'XIX'   => 80,
        'XX'    => 0,
        'XXI'   => 20,
        'XXII'  => 40,
        'XXIII' => 60,
    );

    /**
     * @var array
     */
    private $weights = array(1, 3, 7, 9, 1, 3, 7, 9, 1, 3, 1);

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

        return substr($this->calculateChecksum($id) % 10, -1, 1) == 0;
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
        $month = substr($date, 2, 2);
        $day = substr($date, 4, 2);
        foreach ($this->centuriesDictionary as $century => $centuryStartYear) {
            if ($this->isDateBelongsToCentury($month, $century)) {
                return $centuryStartYear . $year . $this->calculateMonthInCentury($month, $century) . $day;
            }
        }
        return '00000000';
    }

    /**
     * @param int $month
     * @param string $century
     * @return int
     */
    private function calculateMonthInCentury($month, $century)
    {
        $month = (int) $month - $this->centuriesMonthIncreaser[$century];
        return ($month < 10) ? 0 . $month : $month;
    }

    /**
     * @param int $month
     * @param string $century
     * @return bool
     */
    private function isDateBelongsToCentury($month, $century)
    {
        return (in_array((int) $month, $this->getCenturiesRange()[$century])) ? true : false;
    }

    /**
     * @return array
     */
    private function getCenturiesRange()
    {
        return array(
            'XIX'   => range(81, 92),
            'XX'    => range(01, 12),
            'XXI'   => range(21, 32),
            'XXII'  => range(41, 52),
            'XXIII' => range(61, 72),
        );
    }

    /**
     * @param string $id
     * @return int
     */
    private function calculateChecksum($id)
    {
        $sum = 0;
        foreach (str_split($id) as $position => $digit) {
            $sum += $digit * $this->weights[$position];
        }

        return $sum;
    }
}