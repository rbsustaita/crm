<?php

namespace App\Models;

use App\Traits\PersonFullName;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Client extends Model
{
    use PersonFullName;
    protected $fillable = [
        'name',
        'trade_name',
        'tax_id',
        'tipo_persona',
        'sector',
        'sub_category',
        'address_id',
        'industry',
        'website',
        'notes',
        'active',
        'user_id',
    ];

    // Relación uno a muchos
    public function user(): HasMany
    {
        return $this->hasMany(User::class);
    }

    // Relación uno a muchos polimórfica
    public function person()
    {
        return $this->morphOne(Person::class, 'personable');
    }

    // Relación uno a muchos (Address)
    public function addresses()
    {
        return $this->hasMany(Address::class);

    }
}
