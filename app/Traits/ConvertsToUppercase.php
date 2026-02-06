<?php

namespace App\Traits;

trait ConvertsToUppercase
{
    /**
     * Lista de atributos que deben convertirse a mayúsculas.
     * Ejemplo: ['rfc', 'apellido_paterno']
     */
/*     protected array $uppercaseAttributes = []; */

    /**
     * Hook para mutar atributos al asignarlos.
     */
    public function setAttribute($key, $value)
    {
        if (in_array($key, $this->uppercaseAttributes) && is_string($value)) {
            $value = mb_strtoupper($value, 'UTF-8');
        }

        return parent::setAttribute($key, $value);
    }
}

