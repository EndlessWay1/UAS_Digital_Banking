<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Beneficiary extends Model
{
    protected $fillable = [
        'user_id',
        'recipient_name',
        'bank_name',
        'alias',
    ];
}
