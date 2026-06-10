<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavingsPocket extends Model
{
    protected $fillable = [
        'user_id',
        'purpose',
        'target_balance',
        'current_balance',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
