<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavingsPocket extends Model
{
    protected $fillable = [
        'user_id',
        'purpose',
        'target_amount',
        'current_amount',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
