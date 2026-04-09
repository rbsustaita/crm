<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contractform extends Model
{
    protected $fillable = [
        'contract_type',
        'identifier',
        'review',
        'effective_date',
        'ui_statements',
        'clauses',
        'is_active',
    ];

    protected $casts = [
        'ui_statements' => 'array',  // convierte JSON a array automáticamente
        'client_statements' => 'array',  // convierte JSON a array automáticamente
        'clauses' => 'array',  // convierte JSON a array automáticamente
        'effective_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function contract()
    {
        return $this->belongsToMany(Contract::class);
    }

}
