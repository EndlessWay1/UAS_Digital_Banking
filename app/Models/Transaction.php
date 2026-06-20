<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Transaction extends Model
{
    protected $fillable = [
        'sender_account_number',
        'receiver_account_number',
        'amount',
        'type',
        'status',
        'description',
        'tags',
    ];
    protected $casts = [
        'tags' => 'array',
    ];
    public function receipt()
    {
        return $this->hasOne(TransactionReceipt::class);
    }
}