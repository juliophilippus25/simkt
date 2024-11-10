<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplyResidency extends Model
{
    protected $keyType = 'string';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'verified_by',
        'verified_at',
        'status',
        'reason',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function verifiedBy()
    {
        return $this->belongsTo(Admin::class, 'verified_by', 'id');
    }

    public function hasPaid()
    {
        return $this->payment && $this->payment->is_accepted;
    }
}
