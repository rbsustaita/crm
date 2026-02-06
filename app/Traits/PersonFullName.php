<?php

namespace App\Traits;

trait PersonFullName
{
    /**
     * Get the full name of the person.
     *
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        $parts = [
            $this->middle_name,
            $this->last_name,
            $this->name,
        ];

        $filtered = array_filter($parts, fn($part) => !blank($part));
        $formatted = array_map(fn($part) => $this->capitalizeFirstWord($part), $filtered);

        return implode(' ', $formatted);
    }
}
