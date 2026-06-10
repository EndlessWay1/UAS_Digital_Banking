<?php

namespace Database\Seeders;

use App\Models\AccountType;
use Illuminate\Database\Seeder;

class AccountTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            [
                'name' => 'Savings',
                'code' => 'savings',
                'description' => 'Rekening tabungan untuk transaksi harian.',
                'minimum_balance' => 0,
            ],
            [
                'name' => 'Investment',
                'code' => 'investment',
                'description' => 'Rekening untuk kebutuhan investasi.',
                'minimum_balance' => 100000,
            ],
            [
                'name' => 'Business',
                'code' => 'business',
                'description' => 'Rekening untuk kebutuhan bisnis.',
                'minimum_balance' => 500000,
            ],
        ];

        foreach ($types as $type) {
            AccountType::updateOrCreate(
                ['code' => $type['code']],
                $type
            );
        }
    }
}