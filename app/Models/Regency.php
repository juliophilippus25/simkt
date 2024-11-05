<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Regency extends Model
{
    protected $keyType = 'string';
    protected $primaryKey = 'user_id';

    public function profiles()
    {
        return $this->hasMany(UserProfile::class, 'regency_id', 'id');
    }
}
