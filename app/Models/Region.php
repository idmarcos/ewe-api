<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_id',
        'region'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];


    /**
     * Get the country of region.
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
