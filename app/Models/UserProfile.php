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
        'birth_date',
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

    public function regency()
    {
        return $this->belongsTo(Regency::class, 'regency_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
