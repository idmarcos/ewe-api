<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'gender_id',
        'name',
        'surname',
        'bio',
        'birthdate',
        'telephone'
    ];


    /**
     * Get the user that owns the profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the gender of profile.
     */
    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }
}
