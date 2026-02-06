<?php

namespace App\Helpers\Traits;

trait ValidatesRfc
{
    public function isValidRfc(string $rfc): bool
    {
        return $this->getRfcType($rfc) !== null;
    }

    public function getRfcType(string $rfc): ?string
    {
        $rfc = mb_strtoupper(trim($rfc), 'UTF-8');
        $length = mb_strlen($rfc);

        $pattern = '/^([A-ZÑ&]{3,4})(\d{2})(0[1-9]|1[0-2])(0[1-9]|[12]\d|3[01])([A-Z\d]{3})$/u';

        if (!preg_match($pattern, $rfc, $matches)) {
            return null;
        }

        $year = (int) $matches[2];
        $month = (int) $matches[3];
        $day = (int) $matches[4];
        $year += ($year < 70) ? 2000 : 1900;

        if (!checkdate($month, $day, $year)) {
            return null;
        }

        return $length === 12 ? 'moral' : ($length === 13 ? 'física' : null);
    }
}


