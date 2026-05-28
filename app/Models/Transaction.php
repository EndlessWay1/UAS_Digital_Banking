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
    ];

    public function receipt()
    {
        return $this->hasOne(TransactionReceipt::class);
    }
}