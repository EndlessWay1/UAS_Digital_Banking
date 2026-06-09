<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TransactionReceipt extends Model
{
    protected $fillable = [
        'transaction_id',
        'receipt_number',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}