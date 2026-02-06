<?php

namespace App\Helpers\Traits;

use Illuminate\Support\Str;

trait RfcTrait
{
    /*     public function generateRfc(string $name, string $lastName, string $motherLastName, string $birthDate): string
    {
        $rfc = Str::upper(substr($lastName, 0, 2));
        $rfc .= Str::upper(substr($motherLastName, 0, 1));
        $rfc .= Str::upper(substr($name, 0, 1));
        $rfc .= Str::replace('-', '', $birthDate);
        return $rfc;
    } */

    public static function rfcValido(?string $rfc): bool
    {
        return self::tipoDePersonaPorRfc($rfc) !== null;
    }

    public static function tipoDePersonaPorRfc(?string $rfc): ?string
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

    public static function rfcExisteEn(string $rfc, string $modelo, string $campo = 'rfc'): bool
    {
        $modelo = '\\App\\Models\\' . \Illuminate\Support\Str::studly($modelo);

        return class_exists($modelo) && $modelo::where($campo, $rfc)->exists();
    }
}
