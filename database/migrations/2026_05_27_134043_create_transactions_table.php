<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id(); // auto generate ID yang unique buat setiap transac
            $table->string('sender_account_number'); // akun pengirim/pengguna
            $table->string('receiver_account_number')->nullable(); // akun penerima; bisa kosong kalo user depoist/withdraw
            $table->decimal('amount', 15, 2);
            $table->enum('type', ['transfer', 'deposit', 'withdraw']);
            $table->enum('status', ['pending', 'success', 'failed']);
            $table->string('description')->nullable(); // optional note
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};