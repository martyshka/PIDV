<?php

namespace cyrkulewski\PIdV\Validator;

/**
 * The French personal identity code (French: Numéro de sécurité sociale (INSEE))
 *
 * Format: syymmlloookkk cc
 * - s is 1 for a male, 2 for a female,
 * - yy are the last two digits of the year of birth,
 * - mm is the month of birth, usually 01 to 12 (but there are special values for persons whose exact date of birth is not known),
 * - ll is the number of the départment of origin : 2 digits, or 1 digit and 1 letter in metropolitan France, 3 digits for overseas.
 * - ooo is the commune of origin (a department is composed of various communes) : 3 digits in metropolitan France or 2 digits for overseas.
 * - kkk is an order number to distinguish people being born at the same place in the same year and month. This number is the one given by the Acte de naissance, an official paper which officialize a birth (and is needed throughout life for various administrative procedures, such as getting an identity card).
 * - 'cc' is the "control key", 01 to 97, equal to 97-(the rest of the number modulo 97) or to 97 if the number is a multiple of 97.
 */
class FR extends AbstractValidator
{
    /**
     * @param string $id
     * @return bool
     */
    public function validate($id)
    {
        $id = $this->cleanFromIrrelevantSymbols($id);
        if (
            ! $this->validateLength($id, 13) ||
            $this->isSexWrong($id) ||
            $this->isYearWrong($id) ||
            $this->isMonthWrong($id) ||
            $this->isBirthDepartmentWrong($id) ||
            $this->isBirthCertificateWrong($id)
        ) {
            return false;
        }
        return true;
    }

    /**
     * @param string $id
     * @return string
     */
    private function cleanFromIrrelevantSymbols($id)
    {
        $id = preg_replace('/[^0-9AB]/', '', $id);
        return $id;
    }

    /**
     * @param string $id
     * @return bool
     */
    private function isSexWrong($id)
    {
        return !in_array($id[0], [1, 2]);
    }

    /**
     * @param string $id
     * @return bool
     */
    private function isYearWrong($id)
    {
        $year = substr($id, 1, 2);
        return !((0 <= $year) && ($year <= 99));
    }

    /**
     * @param string $id
     * @return bool
     */
    private function isMonthWrong($id)
    {
        $month = substr($id, 3, 2);
        return !((1 <= $month) && ($month <= 12) || ($month == 20));
    }

    /**
     * France Outside: '99(00[1-9]|0[1-9][0-9]|[1-8][0-9][0-9]|9[0-8][0-9]|990)';
     * France Non Continental: '(97[0-9]|98[0-9])(0[1-9]|[1-8][0-9]|90)';
     * France: '(0[1-9]|[1-8][0-9]|9[1-5]|2[AB])(00[1-9]|0[1-9][0-9]|[1-8][0-9][0-9]|9[0-8][0-9]|990)';
     *
     * @param string $id
     * @return bool
     */
    private function isBirthDepartmentWrong($id)
    {
        $str = substr($id, 5, 5);
        $regexp = '/^(99(00[1-9]|0[1-9][0-9]|[1-8][0-9][0-9]|9[0-8][0-9]|990))|((97[0-9]|98[0-9])(0[1-9]|[1-8][0-9]|90))|((0[1-9]|[1-8][0-9]|9[1-5]|2[AB])(00[1-9]|0[1-9][0-9]|[1-8][0-9][0-9]|9[0-8][0-9]|990))$/';
        return (preg_match($regexp, $str, $match) == 1) ? false : true;
    }

    /**
     * @param string $id
     * @return bool
     */
    private function isBirthCertificateWrong($id)
    {
        $str = substr($id, 10, 3);
        $regexp = '/^\d{3}$/';
        return (preg_match($regexp, $str, $match) == 1) ? false : true;
    }
}