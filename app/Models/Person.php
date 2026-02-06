<?php

namespace App\Models;

use App\Traits\PersonFullName;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    /** @use HasFactory<\Database\Factories\PersonFactory> */
    use HasFactory;
    use PersonFullName;

    protected $fillable = [
        'name', 
        'middle_name', 
        'last_name', 
        'email', 
        'phone', 
        'rfc', 
        'personable_id', 
        'personable_type'
    ];
//Se llevo a un trait
/*     public function getFullNameAttribute(): string
    {
        $parts = [
            $this->middle_name,
            $this->last_name,
            $this->name,
        ];

        $filtered = array_filter($parts, fn($part) => !blank($part));
        $formatted = array_map(fn($part) => $this->capitalizeFirstWord($part), $filtered);

        return implode(' ', $formatted);
    } */

    protected function capitalizeFirstWord(?string $value): string
    {
        if (blank($value)) return '';

        return mb_convert_case(mb_strtolower(trim($value), 'UTF-8'), MB_CASE_TITLE, 'UTF-8');
    }


    public function roles()
    {
        return $this->belongsToMany(Role::class, 'person_role');
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function client()
    {
        return $this->hasOne(Client::class);
    }

/*     Uncomment if you want to use the addresses reclationship */
    public function addresses()
    {
        return $this->hasMany(Address::class);
    } 
    
   public function personable()
   {
       return $this->morphTo();
   }
}
