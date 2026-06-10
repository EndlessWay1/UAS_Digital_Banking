<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cardless extends Model
{
    use HasFactory;

    protected $table = 'cardless';
    
    protected $fillable = [
        'user_id',
        'amount',
        'type',
        'status',
        'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}