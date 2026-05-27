<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaction_receipts', function (Blueprint $table) {
            $table->id(); // auto generate unique ID buat semua resi
            $table->foreignId('transaction_id')->constrained('transactions')->onDelete('cascade'); 
            $table->string('receipt_number')->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaction_receipts');
    }
};