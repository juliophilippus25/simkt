<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $keyType = 'string';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'name',
        'price',
        'room_type',
        'status'
    ];

    public function userRooms()
    {
        return $this->hasMany(UserRoom::class);
    }
}
