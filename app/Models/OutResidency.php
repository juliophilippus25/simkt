<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OutResidency extends Model
{
    protected $keyType = 'string';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'user_id',
        'verified_by',
        'verified_at',
        'reason',
        'status',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function verifiedBy() {
        return $this->belongsTo(Admin::class, 'verified_by');
    }
}
