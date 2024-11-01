<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $keyType = 'string';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'name',
        'nik',
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
}
