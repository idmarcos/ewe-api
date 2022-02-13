<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        'country',
        'iso',
        'iso3',
        'code'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    
    /**
     * Get the regions for the country.
     */
    public function regions()
    {
        return $this->hasMany(Region::class);
    }
}
