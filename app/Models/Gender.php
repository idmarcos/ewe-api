<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
    use HasFactory;

    protected $fillable = [
        'gender'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];


    /**
     * Get the profiles for the gender.
     */
    public function user_profiles()
    {
        return $this->hasMany(UserProfile::class);
    }
}
