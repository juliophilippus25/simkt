<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $keyType = 'string';
    protected $primaryKey = 'user_id';

    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'gender',
        'regency_id',
        'nim',
        'university',
        'major',
        'ktp',
        'family_card',
        'active_student',
        'photo',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
